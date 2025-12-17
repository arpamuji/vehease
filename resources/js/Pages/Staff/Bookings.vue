<script lang="ts">
    import Button from '@/Components/ui/button/Button.vue';
    import MainLayout from '@/Layouts/MainLayout.vue';

    export default {
        layout: MainLayout,
    };
</script>
<script lang="ts" setup>
    import PageHeader from '@/Components/custom/PageHeader.vue';
    import {
        Sheet,
        SheetClose,
        SheetContent,
        SheetDescription,
        SheetFooter,
        SheetHeader,
        SheetTitle,
    } from '@/Components/ui/sheet';
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
    <!-- <Table>
        <TableCaption>A list of available vehicles.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead>Status</TableHead>
                <TableHead>Tanggal Booking</TableHead>
                <TableHead>Kendaraan</TableHead>
                <TableHead>Driver</TableHead>
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
    </Table> -->

    <Sheet v-model:open="isSheetOpen">
        <SheetContent>
            <SheetHeader>
                <SheetTitle>Request Vehicle</SheetTitle>
                <SheetDescription> Fill in the details below to request a vehicle booking. </SheetDescription>
            </SheetHeader>
            <div>
                <Form action="/staff/bookings" method="post">
                    <div class="mb-4">
                        <label for="start_date" class="mb-2 block font-medium">Start Date</label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            class="border-input bg-background focus:ring-primary w-full rounded-md border px-3 py-2 focus:ring-2 focus:outline-none"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="mb-2 block font-medium">End Date</label>
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            class="border-input bg-background focus:ring-primary w-full rounded-md border px-3 py-2 focus:ring-2 focus:outline-none"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="purpose" class="mb-2 block font-medium">Purpose</label>
                        <textarea
                            id="purpose"
                            name="purpose"
                            rows="4"
                            class="border-input bg-background focus:ring-primary w-full rounded-md border px-3 py-2 focus:ring-2 focus:outline-none"
                        ></textarea>
                    </div>
                </Form>
            </div>
            <SheetFooter>
                <Button type="submit"> Submit </Button>
                <SheetClose as-child>
                    <Button variant="outline">Close</Button>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
