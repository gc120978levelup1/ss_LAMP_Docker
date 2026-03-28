
# Front End Sample Code Guide ([Laravel 12](https://laravel.com/docs/12.x/installation))

## Pre Requisite

* [Backend Coding is Completed]((https://github.com/gc120978levelup1/ss_LAMP_Docker/blob/master/README%20file%20Backend%20Guide.md)) 
* Register and Login to the web app being coded.

------------------------------------------------------------------

### shadcn components (primary laravel 12 frontend component)
* https://ui.shadcn.com/docs/components/accordion

------------------------------------------------------------------

### Update Icon

Note: put your favicon.jpg in /public folder

* /resources/views/app.blade.php

Insert inside the header below @inertiaHead
```sh
<link rel="icon" type="image/x-icon" href="favicon.jpg">
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
## Add More Menu in the Side Bar

* /resources/js/components/AppSidebar.vue

copy and replace the code below ...

```sh

<script setup lang="ts">
import { Link, } from '@inertiajs/vue3';
import { UserPen, LayoutGrid, Hammer, Map } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import { dashboard } from '@/routes';
import { index as index_complaint } from '@/routes/complaint';
import { show as show_map } from '@/routes/map';
import { edit } from '@/routes/profile';

import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: Map,
    },
    {
        title: 'Complaint',
        href: index_complaint(),
        icon: Hammer,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Edit My Profile',
        href: edit(),
        icon: UserPen,
    },
];

</script>

<template>
    <Sidebar collapsible="icon" variant="inset" class=" z-2000 ">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter class=" z-3000 ">
            <NavFooter :items="footerNavItems" />
            <NavUser class=" z-4000 " />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>


```

------------------------------------------------------------------

### Nav Footer
## Modify NavFooter to activate logout

* /resources/js/components/AppSidebar.vue

copy and replace the code below ...

```sh

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import {
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { toUrl } from '@/lib/utils';
import { logout } from '@/routes';
import type { NavItem } from '@/types';

type Props = {
    items: NavItem[];
    class?: string;
};

defineProps<Props>();

const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent>
            <SidebarMenu>
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton
                        class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
                        as-child>
                        <a :href="toUrl(item.href)" target="_blank" rel="noopener noreferrer">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
                <SidebarMenuButton>
                    <Link
                        class="flex text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
                        :href="logout()" @click="handleLogout" as="button" data-test="logout-button">
                        <LogOut class="mr-2 h-4 w-4" />
                        Log out
                    </Link>
                </SidebarMenuButton>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>

```

------------------------------------------------------------------

# Create Folders and Vue Files

## Install Leaflet for mapping and others

```sh

npm install leaflet
npm install bootstrap
npm install bootstrap-icons
npm install uid
npm install @iconify/vue
npm install @popperjs/core
npm install -D sass-embedded

```

## Modify app.css

copy and replace

```sh

@import 'leaflet/dist/leaflet.css';
@import 'tailwindcss';

@import 'tw-animate-css';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';

@custom-variant dark (&:is(.dark *));

@theme inline {
    --font-sans:
        Instrument Sans, ui-sans-serif, system-ui, sans-serif,
        'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
        'Noto Color Emoji';

    --radius-lg: var(--radius);
    --radius-md: calc(var(--radius) - 2px);
    --radius-sm: calc(var(--radius) - 4px);

    --color-background: var(--background);
    --color-foreground: var(--foreground);

    --color-card: var(--card);
    --color-card-foreground: var(--card-foreground);

    --color-popover: var(--popover);
    --color-popover-foreground: var(--popover-foreground);

    --color-primary: var(--primary);
    --color-primary-foreground: var(--primary-foreground);

    --color-secondary: var(--secondary);
    --color-secondary-foreground: var(--secondary-foreground);

    --color-muted: var(--muted);
    --color-muted-foreground: var(--muted-foreground);

    --color-accent: var(--accent);
    --color-accent-foreground: var(--accent-foreground);

    --color-destructive: var(--destructive);
    --color-destructive-foreground: var(--destructive-foreground);

    --color-border: var(--border);
    --color-input: var(--input);
    --color-ring: var(--ring);

    --color-chart-1: var(--chart-1);
    --color-chart-2: var(--chart-2);
    --color-chart-3: var(--chart-3);
    --color-chart-4: var(--chart-4);
    --color-chart-5: var(--chart-5);

    --color-sidebar: var(--sidebar-background);
    --color-sidebar-foreground: var(--sidebar-foreground);
    --color-sidebar-primary: var(--sidebar-primary);
    --color-sidebar-primary-foreground: var(--sidebar-primary-foreground);
    --color-sidebar-accent: var(--sidebar-accent);
    --color-sidebar-accent-foreground: var(--sidebar-accent-foreground);
    --color-sidebar-border: var(--sidebar-border);
    --color-sidebar-ring: var(--sidebar-ring);
}

@layer base {
    *,
    ::after,
    ::before,
    ::backdrop,
    ::file-selector-button {
        border-color: var(--color-gray-200, currentColor);
    }
}

@layer utilities {
    body,
    html {
        --font-sans:
            'Instrument Sans', ui-sans-serif, system-ui, sans-serif,
            'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
            'Noto Color Emoji';
    }
}

:root {
    --background: hsl(0 0% 100%);
    --foreground: hsl(0 0% 3.9%);
    --card: hsl(0 0% 100%);
    --card-foreground: hsl(0 0% 3.9%);
    --popover: hsl(0 0% 100%);
    --popover-foreground: hsl(0 0% 3.9%);
    --primary: hsl(0 0% 9%);
    --primary-foreground: hsl(0 0% 98%);
    --secondary: hsl(0 0% 92.1%);
    --secondary-foreground: hsl(0 0% 9%);
    --muted: hsl(0 0% 96.1%);
    --muted-foreground: hsl(0 0% 45.1%);
    --accent: hsl(0 0% 96.1%);
    --accent-foreground: hsl(0 0% 9%);
    --destructive: hsl(0 84.2% 60.2%);
    --destructive-foreground: hsl(0 0% 98%);
    --border: hsl(0 0% 92.8%);
    --input: hsl(0 0% 89.8%);
    --ring: hsl(0 0% 3.9%);
    --chart-1: hsl(12 76% 61%);
    --chart-2: hsl(173 58% 39%);
    --chart-3: hsl(197 37% 24%);
    --chart-4: hsl(43 74% 66%);
    --chart-5: hsl(27 87% 67%);
    --radius: 0.5rem;
    --sidebar-background: hsl(0 0% 98%);
    --sidebar-foreground: hsl(240 5.3% 26.1%);
    --sidebar-primary: hsl(0 0% 10%);
    --sidebar-primary-foreground: hsl(0 0% 98%);
    --sidebar-accent: hsl(0 0% 94%);
    --sidebar-accent-foreground: hsl(0 0% 30%);
    --sidebar-border: hsl(0 0% 91%);
    --sidebar-ring: hsl(217.2 91.2% 59.8%);
    --sidebar: hsl(0 0% 98%);
}

.dark {
    --background: hsl(0 0% 3.9%);
    --foreground: hsl(0 0% 98%);
    --card: hsl(0 0% 3.9%);
    --card-foreground: hsl(0 0% 98%);
    --popover: hsl(0 0% 3.9%);
    --popover-foreground: hsl(0 0% 98%);
    --primary: hsl(0 0% 98%);
    --primary-foreground: hsl(0 0% 9%);
    --secondary: hsl(0 0% 14.9%);
    --secondary-foreground: hsl(0 0% 98%);
    --muted: hsl(0 0% 16.08%);
    --muted-foreground: hsl(0 0% 63.9%);
    --accent: hsl(0 0% 14.9%);
    --accent-foreground: hsl(0 0% 98%);
    --destructive: hsl(0 84% 60%);
    --destructive-foreground: hsl(0 0% 98%);
    --border: hsl(0 0% 14.9%);
    --input: hsl(0 0% 14.9%);
    --ring: hsl(0 0% 83.1%);
    --chart-1: hsl(220 70% 50%);
    --chart-2: hsl(160 60% 45%);
    --chart-3: hsl(30 80% 55%);
    --chart-4: hsl(280 65% 60%);
    --chart-5: hsl(340 75% 55%);
    --sidebar-background: hsl(0 0% 7%);
    --sidebar-foreground: hsl(0 0% 95.9%);
    --sidebar-primary: hsl(360, 100%, 100%);
    --sidebar-primary-foreground: hsl(0 0% 100%);
    --sidebar-accent: hsl(0 0% 15.9%);
    --sidebar-accent-foreground: hsl(240 4.8% 95.9%);
    --sidebar-border: hsl(0 0% 15.9%);
    --sidebar-ring: hsl(217.2 91.2% 59.8%);
    --sidebar: hsl(240 5.9% 10%);
}

@layer base {
    * {
        @apply border-border outline-ring/50;
    }
    body {
        @apply bg-background text-foreground;
    }
}


```

## Modify Dashboard.vue

* /resources/js/pages/Dashboard.vue

copy and replace
```sh


<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { Search, LocateFixed, UtilityPole, Gauge, FileClock, RefreshCw } from 'lucide-vue-next';
import { ref, onMounted } from "vue";

import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Button } from '@/components/ui/button';

import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

import { Input } from '@/components/ui/input';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];

onMounted(() => {
    // on page load
});

const whereAmILocatedClick = () => {

}

</script>

<template>

    <Head title="Dashboard"></Head>

    <div v-show="loading" class="absolute top-0 flex w-full h-full bg-gray-950 z-6000 opacity-97">
        <span class="m-auto animate-spin">
            <RefreshCw :size="60" />
        </span>
    </div>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <header
                class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
                <div class="flex items-center gap-2 w-full">
                    <SidebarTrigger class="-ml-1" />
                    <template v-if="breadcrumbs && breadcrumbs.length > 0">
                        <Breadcrumbs :breadcrumbs="breadcrumbs" />
                    </template>
                    <div class="flex gap-1 ml-auto">

                        <!-- Menu Buttons in top lef AppBar Start -->
                        <Button class=" bg-gray-900 text-blue-200 hover:bg-gray-800" @click="whereAmILocatedClick">
                            <LocateFixed />
                        </Button>
                        <Button class=" bg-gray-900 text-blue-200 hover:bg-gray-800" @click="whereAmILocatedClick">
                            <UtilityPole />
                        </Button>
                        <Button class=" bg-gray-900 text-blue-200 hover:bg-gray-800" @click="whereAmILocatedClick">
                            <Gauge />
                        </Button>
                        <Dialog class="z-4000">
                            <DialogTrigger as-child>
                                <Button class=" bg-gray-900 text-blue-200 hover:bg-gray-800">
                                    <FileClock />
                                </Button>
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>
                                        Search History
                                    </DialogTitle>
                                    <DialogDescription>
                                        Lists of past searches ...
                                    </DialogDescription>
                                </DialogHeader>
                                <!------------------------ BODY STARTS ----------------------------->
                                <div
                                    class="w-[100%] max-h-[300px] overflow-auto grid grid-flow-row-dense grid-cols-4 gap-2">


                                </div>
                                <!------------------------- BODY ENDS ----------------------------->
                                <DialogFooter>
                                    <Input class=" shadow-red-800" v-show="showConfirmDelete" v-model="deleteAll"
                                        placeholder='Type in "delete all" to confirm'></Input>
                                    <Button variant="destructive" @click="whereAmILocatedClick">
                                        Clear All
                                    </Button>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>

                        <div class="flex ml-2">
                            <Button class=" rounded-2xl rounded-r-none bg-gray-900 text-blue-200 hover:bg-gray-800"
                                @click="whereAmILocatedClick">
                                <Search />
                            </Button>
                            <Input class=" rounded-l-none" placeholder="Search" v-model="customerID" />
                        </div>
                        <!-- Menu Buttons in top lef AppBar Ended -->

                    </div>
                </div>
            </header>

            <div class="flex z-50 h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div
                    class="z-150 min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">

                    <!-- Main Content Start -->
                    <div id="map" style="height: 100%; background-color: beige;" class="rounded-xl"></div>
                    <!-- Main Content Ended -->

                </div>
            </div>

        </AppContent>
    </AppShell>

</template>

```

## Folder to Create

* /resources/js/pages/viewjs/complaint/

------------------------------------------------------------------

## Files to Create

### Layout

this file acts like a sub menu of the side bar main menu

* /resources/js/pages/viewjs/complaint/Layout.vue

```sh

<script setup lang="ts">
import { Link, /*usePage*/ } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';

import {
    index as index_complaint,
    create as create_complaint
} from '@/routes/complaint';

import type { NavItem } from '@/types';

const modelName = "Customer Complaints Page";
const description = "This is the model for customer complaints. You can view, create, update, and delete complaints.";
const sidebarNavItems: NavItem[] = [
    {
        title: 'Complaint Index',
        href: index_complaint(),
    },
    {
        title: 'Create New',
        href: create_complaint(),
    },

];

//const page = usePage();

//const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
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
import { Head, useForm, /*usePage,*/ } from '@inertiajs/vue3';
import { ref, } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

import {
    post as post_complaint
} from '@/routes/complaint';

import type { BreadcrumbItem, /*SharedData, User*/ } from '@/types';
import SettingsLayout from './Layout.vue';



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

//const page = usePage<SharedData>();
//const user = page.props.auth.user as User;

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
    form.post(post_complaint(), {
        preserveScroll: true,
    });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading v-bind:title="headTitle" v-bind:description="description" />
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
                        <Input id="addtrss" class="mt-1 block w-full" v-model="form.address" required autocomplete="address"
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

import { Head, useForm, /*Link, usePage */} from '@inertiajs/vue3';

import { ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

import {
    update as update_complaint,
} from '@/routes/complaint';

import type { BreadcrumbItem, /* SharedData, User*/ } from '@/types';
import SettingsLayout from './Layout.vue';

interface Props {
    complaint: object,
}

const props = defineProps<Props>();

const headTitle = "Modify Customer Complaint";
const description = "Input data change for customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Edit Complaint',
    href: '/complaint/edit',
},];

//const page = usePage<SharedData>();
//const user = page.props.auth.user as User;

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
    form.post(update_complaint({ id: form.id }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading v-bind:title="headTitle" v-bind:description="description" />
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
                            <Button :disabled="form.processing">Update</Button>
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

import { Head, Link, useForm, /* usePage */} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

import {
    index as index_complaint,
    show as show_complaint,
    edit as edit_complaint,
} from '@/routes/complaint';

import type {  BreadcrumbItem, /* SharedData,  User */ } from '@/types';
import SettingsLayout from './Layout.vue';


interface Props {
    complaints: { type: Array, },
    accountnumber : string,
}

const props = defineProps<Props>();

const headTitle = "Complaint Master List";
const description = "Master lisr of customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Complaint Index',
    href: '/complaint',
},];

//const page = usePage<SharedData>();
//const user = page.props.auth.user as User;

const form = useForm({
    'accountnumber': props.accountnumber,
});

const submit = () => {
    form.get(index_complaint(), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head v-bind:title="headTitle" />
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading v-bind:title="headTitle" v-bind:description="description" />
                <form @submit.prevent="submit" class="space-y-6">

                    <div class="grid gap-2">
                        <Label for="accountnumber">Account Number</Label>
                        <Input id="accountnumber" class="mt-1 block w-full" v-model="form.accountnumber" required
                            autocomplete="accountnumber" placeholder="accountnumber" />
                        <InputError class="mt-2" :message="form.errors.accountnumber" />
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="ml-auto my-auto">
                            <Button :disabled="form.processing">
                                Search
                            </Button>
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
                                    <td class="flex whitespace-nowrap px-6 py-3">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger>
                                                <div
                                                    class="flex items-center space-x-2 border border-neutral-200 dark:border-white/10 rounded-full p-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    >>
                                                </div>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <div
                                                    class="flex p-2 space-y-2 border-b border-neutral-200 dark:border-white/10">
                                                    <Link :href="show_complaint({ id: complaint.id })" class="p-2 px-5 rounded my-auto text-white bg-green-600 m-2">
                                                    View
                                                    </Link>

                                                    <Link :href="edit_complaint({ id: complaint.id })" class="p-2 px-6 rounded my-auto text-white bg-blue-500 m-2">
                                                    Edit
                                                    </Link>

                                                    <DangerButton class="p-2 rounded my-auto text-white bg-red-500 m-2"
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
                                        <div v-if="complaint.picture" class="grid gap-2 w-12.5">
                                            <img :src="complaint.picture" alt="" srcset="" class="border-2 rounded-lg">
                                        </div>
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
import { Head, /*Link,*/ useForm, /* usePage */ } from '@inertiajs/vue3';

//import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';

import {
    index as index_complaint
} from '@/routes/complaint';

import type { BreadcrumbItem, /* SharedData, User */ } from '@/types';
import SettingsLayout from './Layout.vue';


interface Props {
    complaint: object,
}

const props = defineProps<Props>();

const headTitle = "View Customer Complaint";
const description = "View a new customer complaint.";
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'View Complaint',
    href: '/complaint/view',
},];

//const page = usePage<SharedData>();
//const user = page.props.auth.user as User;

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
    form.get(index_complaint(), {
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

                    <div v-if="form.picture" class="grid gap-2">
                        <img :src="form.picture" alt="" srcset="" class="border-2 rounded-lg">
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

### Note: 
    If page is intended for file upload. Dont let the iploaded file to travel accross pages since it will be lost even you use    cacheing. Design the interface to upload right away the said file.

# All Done ... 
