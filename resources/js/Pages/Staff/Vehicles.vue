<script lang="ts" setup>
    import PageHeader from '@/Components/custom/PageHeader.vue';
    import {
        Table,
        TableBody,
        TableCaption,
        TableCell,
        TableFooter,
        TableHead,
        TableHeader,
        TableRow,
    } from '@/Components/ui/table';
    import { Head } from '@inertiajs/vue3';

    interface Vehicle {
        id: string;
        class: string;
        brand: string;
        model: string;
        license_number: string;
        color: string;
    }

    defineProps<{ vehicles: Vehicle[] }>();
</script>

<template>
    <Head title="Vehicles" />
    <PageHeader title="Vehicles" />
    <Table>
        <TableCaption>A list of available vehicles.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead>Tipe</TableHead>
                <TableHead>Plat Nomor</TableHead>
                <TableHead>Brand</TableHead>
                <TableHead>Model</TableHead>
                <TableHead>Warna</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="vehicle in vehicles" :key="vehicle.id">
                <TableCell>{{ vehicle.class }}</TableCell>
                <TableCell>{{ vehicle.license_number }}</TableCell>
                <TableCell>{{ vehicle.brand }}</TableCell>
                <TableCell>{{ vehicle.model }}</TableCell>
                <TableCell>{{ vehicle.color }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
