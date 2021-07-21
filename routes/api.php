<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\MechanicController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product', [ProductController::class, 'index']);

Route::get('/customer', [CustomerController::class, 'index']);
Route::post('/customer/register', [CustomerController::class, 'register']);
Route::post('/customer/login', [CustomerController::class, 'login']);
Route::get('/customer/profile', [CustomerController::class, 'profile'])->middleware('auth:customer');
Route::put('/customer/profile', [CustomerController::class, 'profile_update'])->middleware('auth:customer');
Route::post('/customer/logout', [CustomerController::class, 'logout'])->middleware('auth:customer');

Route::get('/package', [PackageController::class, 'index']);
Route::get('/package/{id}', [PackageController::class, 'show']);
Route::get('/mechanic', [MechanicController::class, 'index']);

// Reservation
Route::post('/reservation', [ReservationController::class, 'store']);
Route::get('/reservation', [ReservationController::class, 'index']);
Route::get('/reservation/mine', [ReservationController::class, 'mine'])->middleware('auth:customer');
Route::get('/reservation/{id}', [ReservationController::class, 'show']);

// Vehicle
Route::post('/vehicle', [VehicleController::class, 'store']);
Route::get('/vehicle', [VehicleController::class, 'index']);
Route::get('/vehicle/mine', [VehicleController::class, 'mine'])->middleware('auth:customer');
Route::get('/vehicle/{id}', [VehicleController::class, 'show']);
Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy'])->middleware('auth:customer');
Route::put('/vehicle/{id}', [VehicleController::class, 'update']);