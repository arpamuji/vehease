<script lang="ts">
    import AdminLayout from '@/Layouts/AdminLayout.vue';

    export default {
        layout: AdminLayout,
    };
</script>
<script lang="ts" setup>
    import PageHeader from '@/Components/custom/PageHeader.vue';
    import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />
    <PageHeader title="Dashboard" />
    <h1>This Dashboard Page</h1>
</template>
