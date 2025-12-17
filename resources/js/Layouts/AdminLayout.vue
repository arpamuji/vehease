<script lang="ts" setup>
    import Sidebar from '@/Components/custom/Sidebar.vue';
    import { SidebarProvider } from '@/Components/ui/sidebar';
    import { House, NotebookPen } from 'lucide-vue-next';

    const adminNavData = {
        navMain: [
            {
                title: 'Dashboard',
                url: '/admin',
                icon: House,
            },
            {
                title: 'Bookings',
                url: '/admin/bookings',
                icon: NotebookPen,
            },
        ],
    };
</script>

<template>
    <SidebarProvider>
        <Sidebar :data="adminNavData" />
        <main class="flex h-screen w-full flex-col items-start px-8 py-8">
            <slot />
        </main>
    </SidebarProvider>
</template>
