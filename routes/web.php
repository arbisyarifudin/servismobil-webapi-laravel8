<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Auth::routes();

Route::get('/', [AuthController::class, 'getLogin'])->name('login');
Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/logout', [AuthController::class, 'postLogout'])->name('logout');

Route::middleware('auth:admin')->group(function () {
    // Tulis routemu di sini.
    Route::get('home', [HomeController::class, 'index']);

    Route::resources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'mechanic' => MechanicController::class,
        'customer' => CustomerController::class,
        'admin' => AdminController::class,
        'package' => PackageController::class,
        'packageproduct' => PackageProductController::class,
        'vehicle' => VehicleController::class,
        'reservation' => ReservationController::class,
        'service' => ServiceController::class,
        'payment' => PaymentController::class,
        'notification' => NotificationController::class,
    ]);

    //     Route::prefix("/product")->group(function ($route) {
    //         $route->get("/", [ProductController::class, 'index']);
    //     });
});

Route::put('/service/{service}/status', [ServiceController::class, 'update_status']);
Route::get('/notification/open/{id}', [NotificationController::class, 'open']);
