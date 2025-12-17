<script lang="ts" setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Car, House, NotebookPen, Users, BarChart, CheckSquare } from 'lucide-vue-next';

    const managerNavData = {
        navMain: [
            {
                title: 'Dashboard',
                url: '/manager',
                icon: House,
            },
            {
                title: 'Bookings',
                url: '/manager/bookings',
                icon: NotebookPen,
            },
            {
                title: 'Approvals',
                url: '/manager/approvals',
                icon: CheckSquare,
            },
            {
                title: 'Team Members',
                url: '/manager/staff',
                icon: Users,
            },
            {
                title: 'Vehicles',
                url: '/manager/vehicles',
                icon: Car,
            },
            {
                title: 'Reports',
                url: '/manager/reports',
                icon: BarChart,
            },
        ],
    };
</script>

<template>
    <MainLayout :data="managerNavData">
        <slot />
    </MainLayout>
</template>