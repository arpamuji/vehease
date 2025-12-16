<?php

namespace Database\Seeders;

use App\Enums\LocationType;
use Helpers\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            'id' => Generator::cuid(),
            'type' => LocationType::MAIN_OFFICE->value,
            'name' => 'Head Office Jakarta',
            'region' => 'Jawa',
            'address' => 'Gedung Menara Tambang Lt. 15, Jl. Sudirman, Jakarta Pusat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $deploymentMap = [
            'Sumatera'   => 2,
            'Kalimantan' => 1,
            'Sulawesi'   => 2,
            'Papua'      => 1,
        ];

        foreach ($deploymentMap as $region => $mineCount) {
            DB::table('locations')->insert([
                'id' => Generator::cuid(),
                'type' => LocationType::BRANCH_OFFICE->value,
                'name' => "Kantor Cabang {$region}",
                'region' => $region,
                'address' => "Jl. Raya {$region} No. 1 (Pusat Kota)",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($i = 1; $i <= $mineCount; $i++) {
                DB::table('locations')->insert([
                    'id' => Generator::cuid(),
                    'type' => LocationType::MINING_SITE->value,
                    'name' => "Tambang {$region} Site-0{$i}",
                    'region' => $region,
                    'address' => "Area Pertambangan Blok {$i}, Pedalaman {$region}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
