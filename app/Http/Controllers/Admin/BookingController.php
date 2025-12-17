<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LocationType;
use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Branch office managers from requester's location
        $branchManagers = User::where('role', RoleType::MANAGER)
            ->join('locations', 'users.location_id', '=', 'locations.id')
            ->where('locations.type', LocationType::BRANCH_OFFICE)
            ->select('users.id as id', 'users.name as name', 'locations.name as location')
            ->orderBy('name')
            ->get();

        // Head office managers only
        $headOfficeManagers = User::where('users.role', RoleType::MANAGER)
            ->join('locations', 'users.location_id', '=', 'locations.id')
            ->where('locations.type', LocationType::MAIN_OFFICE)
            ->select('users.id as id', 'users.name as name', 'locations.name as location')
            ->orderBy('name')
            ->get();

        $vehicles = DB::table('vehicles')
            ->join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->select('vehicles.id as id', 'brand', 'model', 'license_number', 'locations.name as location')
            ->orderBy('location')
            ->orderBy('brand')
            ->get();

        $drivers = User::where('role', '=', RoleType::STAFF)
            ->join('locations', 'users.location_id', '=', 'locations.id')
            ->where('users.role', RoleType::STAFF)
            ->select('users.id as id', 'users.name as name', 'locations.name as location')
            ->orderBy('location')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Bookings', [
            'managers' => [
                'branch' => $branchManagers,
                'head_office' => $headOfficeManagers,
            ],
            'vehicles' => $vehicles,
            'drivers' => $drivers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purpose' => 'required|string|max:300',
            'vehicleId' => 'required|string|exists:vehicles,id',
            'driverId' => 'required|string|exists:users,id',
            'branchManagerId' => 'nullable|string|exists:users,id',
            'headOfficeManagerId' => 'nullable|string|exists:users,id',
        ]);
        $user = Auth::user();

        DB::transaction(function () use ($data, $user) {
            $booking = Booking::create([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'vehicle_id' => $data['vehicleId'],
                'driver_id' => $data['driverId'],
                'requester_id' => $user->id,
                'note' => $data['purpose'],
                'status' => 'PENDING',
            ]);

            $approvalData = [];

            $branchManager = User::find($data['branchManagerId']);
            $headOfficeManager = User::find($data['headOfficeManagerId']);

            if ($branchManager === null && $headOfficeManager === null) {
                throw new \Exception('At least one approver must be selected.');
            }

            array_push(
                $approvalData,
                [
                    'booking_id' => $booking->id,
                    'approver_id' => $branchManager->id,
                    'status' => 'PENDING',
                    'level' => 2,
                ],
                [
                    'booking_id' => $booking->id,
                    'approver_id' => $headOfficeManager->id,
                    'status' => 'PENDING',
                    'level' => 1,
                ]
            );

            $query = $booking->approvals()->createMany($approvalData);

            if ($query === null) {
                throw new \Exception('Failed to create approval records.');
            }

            return response()->json([
                'message' => 'Berhasil disetujui',
                'data' => $booking // Opsional, kalau mau update UI pakai data baru
            ], 200);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
