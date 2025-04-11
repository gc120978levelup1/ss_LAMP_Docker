# Back End Sample Code Guide ([Laravel 12](https://laravel.com/docs/12.x/installation))

## Initialize your Laravel project

```sh
php artisan key:generate
php artisan storage:link
php artisan migrate
```

### package.json, in <scripts> insert the code below

```sh
"serve": "concurrently  \"npm run dev\" \"php artisan serve\"",
```

## Create Complete Model, Controller, Request, migrations
Note: model name should be capitalized and singular forn

```sh
php artisan make:Model Complaint -a
```

## Files to be Edited After making a [Model](https://laravel.com/docs/12.x/eloquent)

### [Migration files](https://laravel.com/docs/12.x/migrations)

* database/migrations/xxxx_xx_xx_xxxxxx_create_complaints_table.php

Add the following code in Schema::create('complaints', function (Blueprint $table)) function
```sh
            $table->string('accountnumber')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('picture')->nullable();
            $table->string('complaint');
```

### To Add New Column to an existing table:

```sh
   php artisan make:migration add_description_to_complaints --table="complaints"
```

* database/migrations/xxxx_xx_xx_xxxxxx_add_description_to_complaints.php

Add the following code in [return new class extends Migration] function
```sh
/**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            //
            $table->dropColumn('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            //
            $table->string('description');
        });
    }
```

### Sample Code to insert in a migration file

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

```sh
    use Inertia\Inertia;
    
    ......

    public function index()
    {
        return Inertia::render('viewjs/complaint/index', [
            'complaints' => Complaint::get()
        ]);
    }
    public function create()
    {
        return Inertia::render('viewjs/complaint/create');
    }
    public function store(StoreComplaintRequest $request)
    {
        $image_path = '';
        if (!$request->hasFile('image_file')) {
            $image_path = '/storage/' . $request->file('image_file')->store('image', 'public');
            $request->merge(['image' => $image_path]);
            $complaint = Complaint::create($request->all());
        }
        return redirect()->route('complaint.show', ['complaint' => $complaint]);
    }
    public function show(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/show',
            ['complaint' => $complaint]
        );
    }
    public function edit(Complaint $complaint)
    {
        return Inertia::render(
            'viewjs/complaint/edit',
            ['complaint' => $complaint]
        );
    }
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        // if update includes saving images, it should ne called by post not put or patch
        $image_path = '';
        if (!$request->hasFile('image_file')) {
            $complaint->update($request->all());
            $image_path = '/storage/' . $request->file('image_file')->store('image', 'public');
            $request->merge(['image' => $image_path]);
        }
        return redirect()->route('complaint.show', ['complaint' => $complaint]);
    }
```
### Request files

* app/Http/Requests/StoreComplaintRequest.php
* app/Http/Requests/UpdateComplaintRequest.php

Note: Add this code inside the Request class to ensure proper read/write access
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

### Route file

* routes/web.php

Sample Routes Code

```sh
  use App\Http\Controllers\ComplaintController;
  Route::middleware('auth')->group(function () {
    //Route::redirect('settings', '/settings/profile');
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::get('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/complaint/post', [ComplaintController::class, 'store'])->name('complaint.post');
    Route::get('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::put('/complaint/{complaint}/update', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::get('/complaint/{complaint}/show', [ComplaintController::class, 'show'])->name('complaint.show');
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