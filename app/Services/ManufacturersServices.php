<?php

namespace App\Services;

use App\Models\Manufacturer;
class ManufacturersServices
{
    public function getManufacturers()
    {
        return Manufacturer::get();
    }

    public function createManufacturer(Array $manufacturer)
    {
        return Manufacturer::create([
            "name" => $manufacturer["name"],
            "code" => $manufacturer["code"],
        ]);
    }

    public function editManufacturer(Int $id, Array $newManufacturer)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->update([
            "name" => $manufacturer["name"],
            "code" => $manufacturer["code"],
            "status" => true,
            "updated_at" => now(),
        ]);
    }

    public function deleteManufacturer(Int $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->delete();
    }
}
