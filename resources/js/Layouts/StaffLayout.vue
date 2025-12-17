<script lang="ts" setup>
    import { Car, House, NotebookPen, MapPin, Fuel } from 'lucide-vue-next';

    const staffNavData = {
        navMain: [
            {
                title: 'Dashboard',
                url: '/staff',
                icon: House,
            },
            {
                title: 'My Bookings',
                url: '/staff/bookings',
                icon: NotebookPen,
            },
            {
                title: 'Available Vehicles',
                url: '/staff/vehicles',
                icon: Car,
            },
            {
                title: 'Trip Logs',
                url: '/staff/trips',
                icon: MapPin,
            },
            {
                title: 'Fuel Records',
                url: '/staff/fuel',
                icon: Fuel,
            },
        ],
    };
</script>

<template>
    <slot />
</template>