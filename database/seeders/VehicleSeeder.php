<?php

namespace Database\Seeders;

use App\Enums\FuelCategory;
use App\Enums\VehicleClass;
use Faker\Factory as Faker;
use Helpers\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    use WithoutModelEvents;
    
    private array $passengerVehicles = [
        ['brand' => 'Toyota', 'models' => ['Avanza', 'Innova', 'Fortuner', 'Alphard', 'Voxy', 'Camry']],
        ['brand' => 'Honda', 'models' => ['Brio', 'Mobilio', 'BR-V', 'HR-V', 'CR-V', 'Civic']],
        ['brand' => 'Mitsubishi', 'models' => ['Xpander', 'Pajero Sport', 'Outlander', 'Eclipse Cross']],
        ['brand' => 'Suzuki', 'models' => ['Ertiga', 'XL7', 'Carry', 'APV']],
        ['brand' => 'Daihatsu', 'models' => ['Xenia', 'Terios', 'Luxio', 'Gran Max']],
        ['brand' => 'Nissan', 'models' => ['Livina', 'Grand Livina', 'X-Trail', 'Terra']],
    ];

    private array $cargoVehicles = [
        ['brand' => 'Isuzu', 'models' => ['Elf', 'Giga', 'Traga', 'D-Max']],
        ['brand' => 'Mitsubishi', 'models' => ['L300', 'Colt Diesel', 'Fuso', 'Triton']],
        ['brand' => 'Hino', 'models' => ['Dutro', 'Ranger', '500 Series', '700 Series']],
        ['brand' => 'Toyota', 'models' => ['Dyna', 'Hilux', 'Land Cruiser']],
        ['brand' => 'Daihatsu', 'models' => ['Gran Max Pickup', 'Gran Max Box']],
    ];

    private array $colors = [
        'White', 'Black', 'Silver', 'Gray', 'Red', 'Blue', 'Yellow', 'Green', 'Brown'
    ];

    private array $licensePrefixes = [
        'B',  // Jakarta
        'D',  // Bandung
        'L',  // Surabaya
        'N',  // Malang
        'BG', // Sumatera Selatan
        'BA', // Sumatera Barat
        'BL', // Aceh
        'BB', // Sumatera Utara
        'KT', // Kalimantan Timur
        'KB', // Kalimantan Barat
        'DA', // Kalimantan Selatan
        'DN', // Sulawesi Selatan
        'DM', // Sulawesi Utara
        'PA', // Papua
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $locations = DB::table('locations')->get();

        for ($i = 1; $i <= 100; $i++) {
            $vehicleClass = $faker->randomElement(VehicleClass::cases());
            
            if ($vehicleClass === VehicleClass::PASSENGER) {
                $vehicle = $faker->randomElement($this->passengerVehicles);
                $fuelCategory = $faker->randomElement([
                    FuelCategory::GASOLINE, 
                    FuelCategory::DIESEL, 
                    FuelCategory::ELECTRIC
                ]);
            } else {
                $vehicle = $faker->randomElement($this->cargoVehicles);
                $fuelCategory = $faker->randomElement([
                    FuelCategory::DIESEL, 
                    FuelCategory::GASOLINE
                ]);
            }

            $model = $faker->randomElement($vehicle['models']);
            $licensePrefix = $faker->randomElement($this->licensePrefixes);
            $licenseNumber = $licensePrefix . ' ' . $faker->numberBetween(1000, 9999) . ' ' . strtoupper($faker->randomLetter() . $faker->randomLetter());
            
            DB::table('vehicles')->insert([
                'id' => Generator::cuid(),
                'class' => $vehicleClass->value,
                'brand' => $vehicle['brand'],
                'model' => $model,
                'license_number' => $licenseNumber,
                'chasis_number' => strtoupper($faker->bothify('MH#??##?????####')),
                'engine_number' => strtoupper($faker->bothify('?##??####??')),
                'color' => $faker->randomElement($this->colors),
                'fuel_category' => $fuelCategory->value,
                'location_id' => $locations->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
