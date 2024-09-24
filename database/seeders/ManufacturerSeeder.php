<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manufacturer::insert([
            [
                "name" => "Renault",
                "code" => "REN",
                "status" => true,
            ],
            [
                "name" => "BMW",
                "code" => "BMW",
                "status" => true,
            ],
            [
                "name" => "Toyotta",
                "code" => "TOT",
                "status" => true,
            ],
            [
                "name" => "Honda",
                "code" => "HON",
                "status" => true,
            ],
        ]);
    }
}
