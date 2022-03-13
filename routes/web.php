<?php

use App\Http\Controllers\ProductBasketController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('/login');
})->middleware('guest');

Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::middleware(['auth:sanctum', 'verified', 'role:cashier'])->group(function () {
    Route::get('/cashier', function () {
        return Inertia::render('Cashier/Dashboard');
    })->name('cashier.dashboard');
});

/**
 * This is a temporary solution for api until i have a proper solution.
 * this solution is not good because it is not microservice.
 */
Route::prefix('api')->group(function () {
    Route::middleware(['auth:sanctum', 'verified', 'role:manager|cashier'])->group(function () {
        Route::apiResource('products', ProductController::class);
    });
    Route::middleware(['auth:sanctum', 'verified', 'role:cashier'])->group(function () {
        Route::apiResource('basket', ProductBasketController::class);
    });
});
