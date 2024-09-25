<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManufacturerController;

Route::fallback(function () {
    return response()->json((object) [
        "message" => "This isn't the route you're looking for.",
        "status" => 404,
    ]);
});

Route::controller(AuthController::class)
    ->prefix('/login')
    ->group(function () {
        Route::post('/', 'login');
    });

Route::middleware('auth:api')->group(function () {
    Route::controller(AuthController::class)
        ->prefix('/auth')
        ->group(function () {
            Route::post('/logout', 'logout');
            Route::prefix('/password')->group(function () {
                Route::post('/', 'changePassword');
                Route::post('/reset', 'resetPassword');
            });
        });

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
