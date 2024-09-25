<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManufacturerController;

Route::fallback(function () {
    return response()->json((object) [
        "message" => "This isn't the route you're looking for.",
        "status" => 404,
    ]);
});

Route::middleware('auth:api')->group(function () {
    Route::controller(ManufacturerController::class)
        ->prefix('/manufacturers')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::delete('/{id}', 'delete');
        }
    );
});
