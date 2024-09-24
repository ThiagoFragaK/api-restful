<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManufacturerController;

Route::middleware('auth:api')->group(function () {
    Route::controller(ManufacturerController::class)
        ->prefix('manufacturer')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{id}', 'edit');
            Route::delete('/{id}', 'delete');
        }
    );
});
