
# Front End Sample Code Guide ([Laravel 12](https://laravel.com/docs/12.x/installation))

## Pre Requisite

* [Backend Coding is Completed]((https://github.com/gc120978levelup1/ss_LAMP_Docker/blob/master/README%20file%20Backend%20Guide.md)) 
* Register and Login to the web app being coded.

------------------------------------------------------------------

### shadcn components (primary laravel 12 frontend component)
* https://ui.shadcn.com/docs/components/accordion

------------------------------------------------------------------

### Update Icon

Note: put your favicon.jpg in /storage/app/public folder

* /resources/views/app.blade.php

Insert inside the header below @inertiaHead
```sh
<link rel="icon" type="image/x-icon" href="/storage/favicon.jpg">
```

------------------------------------------------------------------

### File for Editing Main Side Bar Menu App Logo Icon (SVG)

this site will convert jpg to svg: https://www.freeconvert.com/

* /resources/js/components/AppLogoIcon.vue

------------------------------------------------------------------

### File for Editing Main Side Bar Menu App Title (Upper Left)
* /resources/js/components/AppLogo.vue

------------------------------------------------------------------

### File for Editing Main Side Bar Menu "Platform"
* /resources/js/components/NavMain.vue

------------------------------------------------------------------

### File for User Button Contents in the Main Sidebar
* /resources/js/components/UserInfo.vue

------------------------------------------------------------------

### File for User Menu Drop Down inside the Main Sidebar
* /resources/js/components/UserMenuContent.vue

------------------------------------------------------------------

### File for Authentication Layout Choices

* /resources/js/layouts/AuthLayout.vue

   can choose:
```sh
      import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
      import AuthLayout from '@/layouts/auth/AuthCardLayout.vue';
      import AuthLayout from '@/layouts/auth/AuthSplitLayout.vue';
```

------------------------------------------------------------------

### File for  Application Layout Choices

* /resources/js/layouts/AuthLayout.vue

   can choose:
```sh
      import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
      import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
```

------------------------------------------------------------------

### Icons Used: lucide-vue-next

https://lucide.dev/icons/

```sh
    import {CloudMoonRain,} from 'lucide-vue-next';
```

------------------------------------------------------------------

### File for Editing Main Side Bar Menu (below "Platform")*most important
### Add More Menu in the Side Bar

* /resources/js/components/AppSidebar.vue

you can add more menu items

```sh
    {
        title: 'Complaint',
        href: '/complaint/create',
        icon: CloudMoonRain,
    },
```

# Create Folders and Vue Files

## Folder to Create

* /resources/js/pages/viewjs/complaint/

------------------------------------------------------------------

## Files to Create

### Layout

this file acts like a sub menu of the side bar main menu

* /resources/js/pages/viewjs/complaint/Layout.vue

```sh
<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const modelName = "Customer Complaints Page";
const description = "This is the model for customer complaints. You can view, create, update, and delete complaints.";
const sidebarNavItems: NavItem[] = [
    {
        title: 'Search',
        href: '/complaint',
    },
    {
        title: 'Create New',
        href: '/complaint/create',
    },
    
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading v-bind:title="modelName" v-bind:description="description" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-x-12 lg:space-y-0">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-x-0 space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
```

---------------------------------------------------------

### Create View

this file acts to insert new data to database

* resources/js/pages/viewjs/complaint/create.vue

```sh

<script setup lang="ts">
import { ref, } from 'vue';
import { Head, Link, useForm, usePage, } from '@inertiajs/vue3';
import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    complaints: {type: Array,},
}

defineProps<Props>();

const headTitle = "Create New Customer Complaint";
const description = "Create a new customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Create New Complaint',
    href: '/complaint/create',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    accountnumber:"",
    name         :"",
    address      :"",
    complaint    :"",
    description  :"",
    picture      :"xxxxx",
    image_file   :null,
});

// Register the form with into local storage
//import mem from '@/extra/gboi_memory';
//mem.register('complaint', form);

const imageURL = ref();
const onPictureChange = (event) => {
    const files = event.target.files;
    imageURL.value = URL.createObjectURL(files[0]); 
    form.image_file = files[0];
};

const submit = () => {
    form.post(route('complaint.post'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required autocomplete="accountnumber"
                            placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                            placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="address">Address</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.address" required autocomplete="address"
                            placeholder="Address" />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="complaint">Complaint</Label>
                        <Input id="complaint" class="mt-1 block w-full" v-model="form.complaint" required autocomplete="complaint"
                            placeholder="complaint" />
                        <InputError class="mt-2" :message="form.errors.complaint" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Input id="description" class="mt-1 block w-full" v-model="form.description" required autocomplete="description"
                            placeholder="Description" />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div v-if="imageURL" class="grid gap-2">
                        <img :src="imageURL" alt="" srcset="" class="border-2 rounded-lg">
                    </div>  

                    <div class="grid gap-2">
                        <Label for="picture">Picture</Label>
                        <Input type="file" accept="image/*" @change="onPictureChange" id="picture" class="mt-1 block w-full"  required autocomplete="picture"
                            placeholder="picture" />
                        <InputError class="mt-2" :message="form.errors.picture" />
                    </div>                 

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Save</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                </form>
            </div>

        </SettingsLayout>
    </AppLayout>
</template>

```

### Edit View

this file acts to edit 1 data row from database

* resources/js/pages/viewjs/complaint/edit.vue

```sh

<script setup lang="ts">

import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
import { ref } from 'vue';

interface Props {
    complaint: Object,
}

const props = defineProps<Props>();

const headTitle = "Modify Customer Complaint";
const description = "Input data change for customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Edit Complaint',
    href: '/complaint/edit',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    id: props.complaint.id,
    accountnumber: props.complaint.accountnumber,
    name: props.complaint.name,
    address: props.complaint.address,
    complaint: props.complaint.complaint,
    description: props.complaint.description,
    picture: props.complaint.picture,
    image_file: null,
    created_at: props.complaint.created_at,
    updated_at: props.complaint.updated_at,
});

const img_url = ref(form.picture);
const encodeImageFileAsURL = (event) => {
    const files = event.target.files;
    img_url.value = URL.createObjectURL(files[0]);
    form.image_file = files[0];
}

const submit = () => {
    console.log(form);
    form.post(route('complaint.update', { id: form.id }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required
                            autocomplete="accountnumber" placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                            placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="address">Address</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.address" required
                            autocomplete="address" placeholder="Address" />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="complaint">Complaint</Label>
                        <Input id="complaint" class="mt-1 block w-full" v-model="form.complaint" required
                            autocomplete="complaint" placeholder="complaint" />
                        <InputError class="mt-2" :message="form.errors.complaint" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Input id="description" class="mt-1 block w-full" v-model="form.description" required
                            autocomplete="description" placeholder="Description" />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="image">Picture</Label>
                        <div v-if="img_url" class="grid gap-2">
                            <img :src="img_url" alt="" srcset="" class="border-2 rounded-lg">
                        </div>
                        <Input type="file" accept="image/*" id="image" class="mt-1 block w-full"
                            @change="encodeImageFileAsURL($event)" />
                        <InputError class="mt-2" :message="form.errors.image_file" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Save</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                </form>
            </div>

        </SettingsLayout>
    </AppLayout>
</template>

```

### Index View

this file acts as db grid to show all data from database

* resources/js/pages/viewjs/complaint/index.vue

```sh

<script setup lang="ts">

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    complaints: { type: Array, },
}

defineProps<Props>();

const headTitle = "Complaint Master List";
const description = "Master lisr of customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Complaint Index',
    href: '/complaint',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    'accountnumber': "",
    'name': "",
    'address': "",
    'description': "",
});

const submit = () => {
    form.post(route('complaint.post'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">

                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required
                            autocomplete="accountnumber" placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Search</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                            </Transition>
                        </div>
                    </div>
                </form>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-auto p-2 border rounded">
                        <table class="min-w-full text-left text-sm font-dark text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                <tr>
                                    <th scope="col" class="px-1 py-4">
                                        Action
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        #
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Accountnumber
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Name
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Address
                                    </th>
                                    <th scope="col" class="px-3 py-4">
                                        Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(complaint, index) in complaints" :key="index"
                                    class="border-b border-neutral-200 dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-3">

                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <div class="flex items-center space-x-2 border border-neutral-200 dark:border-white/10 rounded-full p-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    >>
                                                </div>

                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <div
                                                    class="flex flex-col p-2 space-y-2 border-b border-neutral-200 dark:border-white/10">
                                                    <Link :href="route(
                                                        'complaint.show',
                                                        [complaint.id]
                                                    )
                                                        " class="p-2 px-5 rounded my-auto text-white bg-green-600">
                                                    View
                                                    </Link>

                                                    <Link :href="route(
                                                        'complaint.edit',
                                                        { id: complaint.id }
                                                    )
                                                        " class="p-2 px-6 rounded my-auto text-white bg-blue-500">
                                                    Edit
                                                    </Link>

                                                    <DangerButton class="p-2 rounded my-auto text-white bg-red-500"
                                                        @click="
                                                            deleteEvent(
                                                                complaint.id
                                                            )
                                                            ">
                                                        Delete
                                                    </DangerButton>
                                                </div>

                                            </DropdownMenuContent>
                                        </DropdownMenu>

                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ complaint.id }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ complaint.accountnumber }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ complaint.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ complaint.address }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ complaint.description }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </SettingsLayout>
    </AppLayout>
</template>

```


### Show View

this file acts to show 1 row data from database

* resources/js/pages/viewjs/complaint/show.vue

```sh

<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from './Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    complaint: Object,
}

const props = defineProps<Props>();

const headTitle = "View Customer Complaint";
const description = "View a new customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'View Complaint',
    href: '/complaint/view',
},];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    id            :props.complaint.id,
    accountnumber :props.complaint.accountnumber, 
    name          :props.complaint.name,
    address       :props.complaint.address,
    complaint     :props.complaint.complaint,
    description   :props.complaint.description,
    picture       :props.complaint.picture,
    created_at    :props.complaint.created_at,
    updated_at    :props.complaint.updated_at,
});


const submit = () => {
    form.get(route('complaint.index'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required autocomplete="accountnumber"
                            placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                            placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="address">Address</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.address" required autocomplete="address"
                            placeholder="Address" />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="complaint">Complaint</Label>
                        <Input id="complaint" class="mt-1 block w-full" v-model="form.complaint" required autocomplete="complaint"
                            placeholder="complaint" />
                        <InputError class="mt-2" :message="form.errors.complaint" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Input id="description" class="mt-1 block w-full" v-model="form.description" required autocomplete="description"
                            placeholder="Description" />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div v-if="form.picture" class="grid gap-2">
                        <img :src="form.picture" alt="" srcset="" class="border-2 rounded-lg">
                    </div> 

                    <div class="grid gap-2">
                        <Label for="created_at">Created At</Label>
                        <Input id="created_at" class="mt-1 block w-full" v-model="form.created_at" required autocomplete="created_at"
                            placeholder="created_at" />
                        <InputError class="mt-2" :message="form.errors.created_at" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="updated_at">Updated At</Label>
                        <Input id="updated_at" class="mt-1 block w-full" v-model="form.updated_at" required autocomplete="updated_at"
                            placeholder="updated_at" />
                        <InputError class="mt-2" :message="form.errors.updated_at" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">Back</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Backed.</p>
                            </Transition>
                        </div>
                    </div>
                </form>
            </div>

        </SettingsLayout>
    </AppLayout>
</template>

```

# All Done ... 