<?php

namespace Database\Seeders;

use App\Enums\LocationType;
use App\Enums\RoleType;
use Faker\Factory as Faker;
use Helpers\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $mainOffice = DB::table('locations')
            ->where('type', LocationType::MAIN_OFFICE->value)
            ->first();
        $branchOffices = DB::table('locations')
            ->where('type', LocationType::BRANCH_OFFICE->value)
            ->get();
        $allLocations = DB::table('locations')->get();
        $defaultPassword = 'password123';

        // 1. Create 1 ROOT user at Main Office
        DB::table('users')->insert([
            'id' => Generator::cuid(),
            'name' => 'Root Administrator',
            'email' => 'root@vehease.com',
            'password' => Hash::make($defaultPassword),
            'role' => RoleType::ROOT->value,
            'location_id' => $mainOffice->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create 2 MANAGERs at Main Office
        for ($i = 1; $i <= 2; $i++) {
            DB::table('users')->insert([
                'id' => Generator::cuid(),
                'name' => $faker->name(),
                'email' => "manager{$i}@vehease.com",
                'password' => Hash::make($defaultPassword),
                'role' => RoleType::MANAGER->value,
                'location_id' => $mainOffice->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Create 1 ADMIN and 1 MANAGER for each branch office (4 branch offices = 4 admins)
        $adminCounter = 1;
        foreach ($branchOffices as $branch) {
            DB::table('users')->insert([
                'id' => Generator::cuid(),
                'name' => $faker->name(),
                'email' => "admin{$adminCounter}@vehease.com",
                'password' => Hash::make($defaultPassword),
                'role' => RoleType::ADMIN->value,
                'location_id' => $branch->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('users')->insert([
                'id' => Generator::cuid(),
                'name' => $faker->name(),
                'email' => "branchmanager{$adminCounter}@vehease.com",
                'password' => Hash::make($defaultPassword),
                'role' => RoleType::MANAGER->value,
                'location_id' => $branch->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $adminCounter++;
        }
        // 4. Create remaining STAFF users (total 35 employees - 1 ROOT - 2 MANAGERs - 4 ADMINs - 4 MANAGERs = 29 STAFF)
        $remainingEmployees = 29;

        for ($i = 1; $i <= $remainingEmployees; $i++) {
            $randomLocation = $allLocations->random();

            DB::table('users')->insert([
                'id' => Generator::cuid(),
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make($defaultPassword),
                'role' => RoleType::STAFF->value,
                'location_id' => $randomLocation->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
