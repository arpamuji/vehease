<script lang="ts">
    import DatePicker from '@/Components/custom/date-picker/DatePicker.vue';
    import Dialog from '@/Components/ui/dialog/Dialog.vue';
    import DialogContent from '@/Components/ui/dialog/DialogContent.vue';
    import DialogDescription from '@/Components/ui/dialog/DialogDescription.vue';
    import DialogFooter from '@/Components/ui/dialog/DialogFooter.vue';
    import DialogHeader from '@/Components/ui/dialog/DialogHeader.vue';
    import DialogTitle from '@/Components/ui/dialog/DialogTitle.vue';
    import Table from '@/Components/ui/table/Table.vue';
    import TableBody from '@/Components/ui/table/TableBody.vue';
    import TableCaption from '@/Components/ui/table/TableCaption.vue';
    import TableCell from '@/Components/ui/table/TableCell.vue';
    import TableHead from '@/Components/ui/table/TableHead.vue';
    import TableHeader from '@/Components/ui/table/TableHeader.vue';
    import TableRow from '@/Components/ui/table/TableRow.vue';
    import { Textarea } from '@/Components/ui/textarea';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
import Separator from '@/Components/ui/separator/Separator.vue';

    export default {
        layout: AdminLayout,
    };
</script>

<script lang="ts" setup>
    import PageHeader from '@/Components/custom/PageHeader.vue';
    import Button from '@/Components/ui/button/Button.vue';
    import {
        Sheet,
        SheetClose,
        SheetContent,
        SheetDescription,
        SheetFooter,
        SheetHeader,
        SheetTitle,
    } from '@/Components/ui/sheet';
    import { Head, useForm } from '@inertiajs/vue3';
    import { Car, Check, CirclePlus, User, UserRoundCheck, X } from 'lucide-vue-next';
    import { computed, ref } from 'vue';

    interface User {
        id: string;
        name: string;
        location: string;
    }

    interface Vehicles {
        id: string;
        brand: string;
        model: string;
        license_number: string;
        location: string;
    }

    interface Props {
        managers: {
            branch: User[];
            head_office: User[];
        };
        vehicles: Vehicles[];
        drivers: User[];
    }

    const { managers, vehicles, drivers } = defineProps<Props>();
    const isBookingSheetOpen = ref(false);
    const isApproverDialogOpen = ref(false);
    const isVehicleDialogOpen = ref(false);
    const isDriverDialogOpen = ref(false);
    const form = useForm({
        start_date: null,
        end_date: null,
        purpose: '' as string,
        vehicleId: null as string | null,
        driverId: null as string | null,
        branchManagerId: null as string | null,
        headOfficeManagerId: null as string | null,
    });

    const selectedVehicle = computed(() => {
        if (!form.vehicleId) return null;
        return vehicles.find((vehicle) => vehicle.id === form.vehicleId);
    });

    const selectedVehicleDisplay = computed(() => {
        if (!selectedVehicle.value) return 'Selected Vehicle Not Found';
        const { model, license_number } = selectedVehicle.value;
        return `${model} (${license_number})`;
    });

    const onSubmit = () => {
        console.log('Form Submitted:', form.data());
        form.post('/admin/bookings', {
            onSuccess: () => {
                isBookingSheetOpen.value = false;
                form.reset();
            },
        });
    };
</script>
<template>
    <Head title="Bookings" />
    <PageHeader title="Bookings">
        <Button type="button" @click="isBookingSheetOpen = true">
            <CirclePlus />
            Booking
        </Button>
    </PageHeader>

    <!-- TODO: Refactor dialogs (Vehicle, Driver, Approver, Requester selection) into reusable components -->
    <!-- Booking Request Sheet -->
    <Sheet v-model:open="isBookingSheetOpen">
        <SheetContent>
            <SheetHeader>
                <SheetTitle>Create Booking</SheetTitle>
                <SheetDescription> Fill in the details below to request a vehicle booking. </SheetDescription>
            </SheetHeader>
            <div class="px-4">
                <form @submit.prevent="onSubmit">
                    <div class="mb-4 flex flex-col">
                        <label for="start_date" class="mb-2 block font-medium">Start Date</label>
                        <DatePicker v-model="form.start_date" id="start_date" class="w-full!" />
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="end_date" class="mb-2 block font-medium">End Date</label>
                        <DatePicker v-model="form.end_date" id="end_date" class="w-full!" />
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="vehicle" class="mb-2 block font-medium">Vehicle</label>
                        <Button type="button" variant="outline" @click="isVehicleDialogOpen = true" class="w-full!">
                            <template v-if="!form.vehicleId">
                                <Car />
                                Select Vehicle
                            </template>
                            <template v-else>
                                <Car />
                                {{ selectedVehicleDisplay }}
                            </template>
                        </Button>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="driver" class="mb-2 block font-medium">Driver</label>
                        <Button type="button" variant="outline" @click="isDriverDialogOpen = true" class="w-full!">
                            <template v-if="!form.driverId">
                                <User />
                                Select Driver
                            </template>
                            <template v-else>
                                <User />
                                {{
                                    drivers.find((driver) => driver.id === form.driverId)?.name ||
                                    'Selected Driver Not Found'
                                }}
                            </template>
                        </Button>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="approval_1" class="mb-2 block font-medium">Approver</label>
                        <Button type="button" variant="outline" @click="isApproverDialogOpen = true" class="w-full!">
                            <template v-if="!form.branchManagerId && !form.headOfficeManagerId">
                                <UserRoundCheck />
                                Select Approver
                            </template>
                            <template v-else>
                                <UserRoundCheck />
                                {{ form.branchManagerId && form.headOfficeManagerId ? 2 : 1 }} Approver(s) Selected
                            </template>
                        </Button>
                    </div>
                    <div class="mb-4">
                        <label for="purpose" class="mb-2 block font-medium">Purpose</label>
                        <Textarea
                            v-model="form.purpose"
                            id="purpose"
                            class="w-full"
                            rows="4"
                            placeholder="Enter the purpose of the booking"
                        />
                    </div>
                </form>
            </div>
            <SheetFooter>
                <Button type="button" @click="onSubmit" :disabled="form.processing"> Submit </Button>
                <SheetClose as-child>
                    <Button type="button" variant="outline">Close</Button>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>

    <!-- Vehicle Selection Dialog -->
    <Dialog v-model:open="isVehicleDialogOpen" class="w-auto">
        <DialogContent class="min-w-2xl">
            <DialogHeader>
                <DialogTitle>Select Vehicle</DialogTitle>
                <DialogDescription> Please select a vehicle for the booking request. </DialogDescription>
            </DialogHeader>
            <div class="max-h-96 space-y-4 overflow-y-auto">
                <!-- TODO: Replace with DataTable component for better filtering, sorting, and pagination, with fixed column header -->
                <Table>
                    <TableCaption>A list of available vehicles.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Brand</TableHead>
                            <TableHead>Model</TableHead>
                            <TableHead>License Number</TableHead>
                            <TableHead class="col-span-2">Location</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="vehicle in vehicles"
                            :key="vehicle.id"
                            :class="[
                                'hover:cursor-pointer',
                                form.vehicleId === vehicle.id ? 'bg-muted' : 'hover:bg-muted',
                            ]"
                        >
                            <TableCell>{{ vehicle.brand }}</TableCell>
                            <TableCell>{{ vehicle.model }}</TableCell>
                            <TableCell>{{ vehicle.license_number }}</TableCell>
                            <TableCell>{{ vehicle.location }}</TableCell>
                            <TableCell>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="icon"
                                    @click="form.vehicleId = null"
                                    v-if="form.vehicleId === vehicle.id"
                                >
                                    <X />
                                </Button>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="icon"
                                    @click="form.vehicleId = vehicle.id"
                                    v-else
                                >
                                    <Check />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </DialogContent>
    </Dialog>

    <!-- Driver Selection Dialog -->
    <Dialog v-model:open="isDriverDialogOpen" class="w-auto">
        <DialogContent class="min-w-2xl">
            <DialogHeader>
                <DialogTitle>Select Driver</DialogTitle>
                <DialogDescription> Please select a driver for the booking request. </DialogDescription>
            </DialogHeader>
            <div class="max-h-96 space-y-4 overflow-y-auto">
                <!-- TODO: Replace with DataTable component for better filtering, sorting, and pagination, with fixed column header -->
                <Table>
                    <TableCaption>A list of available drivers.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead class="col-span-2">Location</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="driver in drivers"
                            :key="driver.id"
                            :class="[
                                'hover:cursor-pointer',
                                form.driverId === driver.id ? 'bg-muted' : 'hover:bg-muted',
                            ]"
                        >
                            <TableCell>{{ driver.name }}</TableCell>
                            <TableCell>{{ driver.location }}</TableCell>
                            <TableCell>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="icon"
                                    @click="form.driverId = null"
                                    v-if="form.driverId === driver.id"
                                >
                                    <X />
                                </Button>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="icon"
                                    @click="form.driverId = driver.id"
                                    v-else
                                >
                                    <Check />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </DialogContent>
    </Dialog>

    <!-- Approver Selection Dialog -->
    <Dialog v-model:open="isApproverDialogOpen">
        <DialogContent class="min-w-2xl">
            <DialogHeader>
                <DialogTitle>Select Approver</DialogTitle>
                <DialogDescription> Please select an approver for the booking request. </DialogDescription>
            </DialogHeader>
            <div class="space-y-4">
                <!-- TODO: Replace with DataTable component for better filtering, sorting, and pagination -->
                <div>
                    <label for="branchmanagers" class="mb-1">Branch Managers</label>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead class="col-span-2">Location</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="manager in managers.branch"
                                :key="manager.id"
                                :class="[
                                    'hover:cursor-pointer',
                                    form.branchManagerId === manager.id ? 'bg-muted' : 'hover:bg-muted',
                                ]"
                            >
                                <TableCell>{{ manager.name }}</TableCell>
                                <TableCell>{{ manager.location }}</TableCell>
                                <TableCell>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="icon"
                                        @click="form.branchManagerId = null"
                                        v-if="form.branchManagerId === manager.id"
                                    >
                                        <X />
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="icon"
                                        @click="form.branchManagerId = manager.id"
                                        v-else
                                    >
                                        <Check />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
                <Separator orientation="horizontal" />
                <div>
                    <label for="branchmanagers" class="mb-1">Head Office Managers</label>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead class="col-span-2">Location</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="manager in managers.head_office"
                                :key="manager.id"
                                :class="[
                                    'hover:cursor-pointer',
                                    form.headOfficeManagerId === manager.id ? 'bg-muted' : 'hover:bg-muted',
                                ]"
                            >
                                <TableCell>{{ manager.name }}</TableCell>
                                <TableCell>{{ manager.location }}</TableCell>
                                <TableCell>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="icon"
                                        @click="form.headOfficeManagerId = null"
                                        v-if="form.headOfficeManagerId === manager.id"
                                    >
                                        <X />
                                    </Button>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="icon"
                                        @click="form.headOfficeManagerId = manager.id"
                                        v-else
                                    >
                                        <Check />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </DialogContent>
    </Dialog>
</template>
