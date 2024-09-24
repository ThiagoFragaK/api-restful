<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Manufacturer;
use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use App\Services\ManufacturersServices;

class ManufacturerController extends Controller
{
    private ManufacturersServices $ManufacturersServices;
    public function __construct()
    {
        $this->ManufacturersServices = new ManufacturersServices();
    }

    public function index(): JsonResponse
    {
        return response()->json((object) [
            "data" => $this->ManufacturersServices->getManufacturers(),
            "status" => 200,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json((object) [
            "message" => "Manufacturer created successfully",
            "data" => $this->ManufacturersServices->createManufacturer([
                "name" => $request->get("name"),
                "code" => $request->get("code"),
            ]),
            "status" => 201,
        ]);
    }

    public function edit(Int $id, Request $request): JsonResponse
    {
        return response()->json((object) [
            "message" => "Manufacturer edited successfully",
            "data" => $this->ManufacturersServices->editManufacturer($id, [
                "name" => $request->get("name"),
                "code" => $request->get("code"),
            ]),
            "status" => 200,
        ]);
    }

    public function destroy(Int $id): JsonResponse
    {
        return response()->json((object) [
            "message" => "Manufacturer deleted successfully",
            "data" => $this->ManufacturersServices->deleteManufacturer($id),
            "status" => 204,
        ]);
    }
}
