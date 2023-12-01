<?php

use App\Http\Controllers\Api\V1\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['throttle:20,1'])->group(function () {
    Route::post('/add-location', [LocationController::class, 'addLocation']);
    Route::get('/location/{id}', [LocationController::class, 'locationDetails']);
    Route::get('/locations', [LocationController::class, 'getAllLocations']);
    Route::post('/sorted-locations', [LocationController::class, 'listLocationsSortedByDistance']);
});
