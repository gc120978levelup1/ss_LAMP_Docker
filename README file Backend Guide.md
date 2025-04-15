# Back End Sample Code Guide ([Laravel 12](https://laravel.com/docs/12.x/installation))

## Edit package.json, in <scripts> insert the code below (optional)

```sh
"serve": "concurrently  \"npm run dev\" \"php artisan serve\"",
```

### Initialize your Laravel project

```sh
npm install -D sass-loader sass
npx shadcn-vue@latest add sonner
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
php artisan key:generate
php artisan storage:link
php artisan migrate
```

### Add alphaenvironment.php to the folder /config
Note: The value of AWS_URL found in .env file can be obtained by buying buckets from AWS S3, Cloudflare R2 and MinIO, etc ...  

* /config/alphaenvironment.php

example for Cloudflare R2:
```sh
<?php
return [
    'LOCAL_URL' => '/storage/',
    
    'AWS_URL1' => 'https://fls-9eaa2509-0ce6-4f12-a40a-e4d4a34152c3.laravel.cloud/',
    'AWS_URL2' => 'https://url2.company2.cloud/',
    'AWS_URL3' => 'https://url3.company3.cloud/',
    'AWS_URL4' => 'https://url4.company4.cloud/',
    'AWS_URL5' => 'https://url5.company5.cloud/',
    'AWS_URL6' => 'https://url6.company6.cloud/',
    'AWS_URL7' => 'https://url7.company7.cloud/',
    'AWS_URL8' => 'https://url8.company8.cloud/',
    'AWS_URL9' => 'https://url9.company9.cloud/',
    'AWS_URL10'=> 'https://url10.company10.cloud/',
    
    'SUB_FLDR_IMAGES' => 'images',
    'SUB_FLDR_XLSX'   => 'excelfiles',
    'SUB_FLDR_DOCX'   => 'worddocs',
    'SUB_FLDR_PPTX'   => 'powerpointfiles',
    'SUB_FLDR_CSV'    => 'csvfiles',
    'SUB_FLDR_TXT'    => 'textfiles',
    'SUB_FLDR_DAT'    => 'datafiles',
    'SUB_FLDR_PDF'    => 'pdf',
    'SUB_FLDR_HTML'   => 'html',
    'SUB_FLDR_ETC'    => 'etc',

    'BUCKET_DISK1' => 's3',          // Amazon Web Service S3 bucket 
    'BUCKET_DISK2' => 'r2',          // cloud flare r2 
    'BUCKET_DISK3' => 'gdisk01',     // customize disk name from S3-compatible disk
    'BUCKET_DISK4' => 'custom_name4',
    'BUCKET_DISK5' => 'custom_name5',
    'BUCKET_DISK6' => 'custom_name6',
    'BUCKET_DISK7' => 'custom_name7',
    'BUCKET_DISK8' => 'custom_name8',
    'BUCKET_DISK9' => 'custom_name9',
    'BUCKET_DISK10' =>'custom_name10',
];
```

## Create Complete Model, Controller, Request, migrations
Note: model name should be capitalized and singular forn

```sh
php artisan make:Model Complaint -a
```

## Files to be Edited After making a [Model](https://laravel.com/docs/12.x/eloquent)

### [Database Migration files](https://laravel.com/docs/12.x/migrations)

* database/migrations/xxxx_xx_xx_xxxxxx_create_complaints_table.php

Add the following code/columns in Schema::create('complaints', function (Blueprint $table)) function
```sh
$table->string('accountnumber')->unique();
$table->string('name');
$table->string('address');
$table->string('picture')->nullable();
$table->string('complaint');
```

### Run Migration
```sh
./ss migrate
```

### To Add New Column to an existing table:

```sh
php artisan make:migration add_description_to_complaints --table="complaints"
```

* database/migrations/xxxx_xx_xx_xxxxxx_add_description_to_complaints.php

Replace the following code in [return new class extends Migration] function
```sh
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('description')->nullable();
        });
    }
```

### Run Migration

```sh
./ss migrate
```

### Sample data to insert in a migration file

```sh
	$table->foreignId('user_id')->constrained();
	$table->double('column_name', 15, 8);
	$table->string('description')->nullable(); 
	$table->integer('column_name');
	$table->text('column_name');
	$table->bigInteger('column_name')->unique();
	$table->dropColumn('description')->nullable();
```

### [Controller File](https://laravel.com/docs/12.x/controllers#main-content)

* app/Http/Controllers/ComplaintController.php

Note: The sample code is for Laravel + Inertia + Vue

ex. code for local or VPS
```sh
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreComplaintRequest $request)
    {
        if ($request["accountnumber"]) { // if index has search parameter
            $complaint = Complaint::where("accountnumber","like","%". $request["accountnumber"] ."%")->get();
            return Inertia::render('viewjs/complaint/index', [
                'complaints' => $complaint,
                'accountnumber' => $request["accountnumber"],
            ]);
        } else // if index has no search parameter
            return Inertia::render('viewjs/complaint/index', [
                'complaints' => Complaint::get()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('viewjs/complaint/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
         // saving and extracting uploaed picture
         if ($request->hasFile('image_file')) {
            $request->merge([
                // local file upload, VPS
                'picture' => config('alphaenvironment.LOCAL_URL') . $request->file('image_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $complaint = Complaint::create($request->all());
        return redirect()->route(
            'complaint.show',
            [
                'complaint' => $complaint
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/show',
            ['complaint' => $complaint]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/edit',
            ['complaint' => $complaint]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        // if update includes saving images, it should ne called by post not put or patch
        // saving and extracting uploaed picture
        if ($request->hasFile('image_file')) {
            $request->merge([
                // local file upload, VPS
                'picture' => config('alphaenvironment.LOCAL_URL') . $request->file('image_file')->store(config('alphaenvironment.SUB_FLDR_IMAGES'), 'public'),
            ]);
        }
        $complaint->update($request->all());
        return redirect()->route('complaint.show', ['complaint' => $complaint]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}

```

ex. code for AWS S3 AND COMPATIBLE BUCKETS
```sh
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

use App\Models\Complaint;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreComplaintRequest $request)
    {
        if ($request["accountnumber"]) { // if index has search parameter
            //('column', 'like', '%SearchString%')
            $complaint = Complaint::where("accountnumber","like","%". $request["accountnumber"] ."%")->get();
            return Inertia::render('viewjs/complaint/index', [
                'complaints' => $complaint,
                'accountnumber' => $request["accountnumber"],
            ]);
        } else // if index has no search parameter
            return Inertia::render('viewjs/complaint/index', [
                'complaints' => Complaint::get()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('viewjs/complaint/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
         // saving and extracting uploaed picture
         if ($request->hasFile('image_file')) {
            //$request->merge([
            //    // local file upload, VPS
            //    'picture' => config('alphaenvironment.LOCAL_URL') . $request->file('image_file')->store(config('alphaenvironment.SUB_FOLDER1'), 'public'),
            //]);

            $request->merge([
                // remote file upload
                'picture' =>  config('alphaenvironment.AWS_URL1') . Storage::disk(config('alphaenvironment.BUCKET_DISK3'))->put(config('alphaenvironment.SUB_FOLDER1'), $request->file('image_file')),
            ]);
        }
        $complaint = Complaint::create($request->all());
        return redirect()->route(
            'complaint.show',
            [
                'complaint' => $complaint
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/show',
            ['complaint' => $complaint]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/edit',
            ['complaint' => $complaint]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        // if update includes saving images, it should ne called by post not put or patch
        // saving and extracting uploaed picture
        if ($request->hasFile('image_file')) {
            $request->merge([
                // remote file upload
                'picture' =>  config('alphaenvironment.AWS_URL1') . Storage::disk(config('alphaenvironment.BUCKET_DISK3'))->put(config('alphaenvironment.SUB_FOLDER1'), $request->file('image_file')),
            ]);
        }
        $complaint->update($request->all());
        return redirect()->route('complaint.show', ['complaint' => $complaint]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}

```

### Request files

* app/Http/Requests/StoreComplaintRequest.php
* app/Http/Requests/UpdateComplaintRequest.php

Note: Replace this code inside the Request classes to ensure proper read/write access
```sh
    public function authorize(): bool
    {
        return true;
    }
```

### [Model file](https://laravel.com/docs/12.x/eloquent#generating-model-classes)

* app/Http/Models/Complaint.php

Note: Add this code inside the model class to ensure proper read/write access
```sh
    protected $guarded = ['id'];
```

### [Route file](https://laravel.com/docs/12.x/routing)

* routes/web.php

Sample Routes Code to Insert

```sh
use App\Http\Controllers\ComplaintController;
Route::middleware('auth')->group(function () {
  Route::get ('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
  Route::get ('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
  Route::post('/complaint/post', [ComplaintController::class, 'store'])->name('complaint.post');
  Route::get ('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
  Route::post('/complaint/{complaint}/update', [ComplaintController::class, 'update'])->name('complaint.update');
  Route::get ('/complaint/{complaint}/show', [ComplaintController::class, 'show'])->name('complaint.show');
});
```

## Summary

### Important Migration Commands:

```sh
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan make:Model Complaint -a
php artisan migrate:rollback
php artisan make:migration add_description_to_complaints --table="complaints"
```

## [MiddleWare](https://laravel.com/docs/12.x/middleware)

#  [Guide For FrontEnd Coding](https://github.com/gc120978levelup1/ss_LAMP_Docker/blob/master/README%20file%20Frontend%20Guide.md)
