<script lang="ts" setup>
    import PageHeader from '@/Components/custom/PageHeader.vue';
    import { Form, Head } from '@inertiajs/vue3';
    import { CirclePlus } from 'lucide-vue-next';
    import { ref } from 'vue';

    const isSheetOpen = ref(false);
</script>
<template>
    <Head title="Bookings" />
    <PageHeader title="Bookings">
        <Button @click="isSheetOpen = true">
            <CirclePlus />
            Booking
        </Button>
    </PageHeader>
</template>
