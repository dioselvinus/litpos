<?php

use App\Http\Controllers\ProductController;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\SimpleExcel\SimpleExcelWriter;

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

Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin|cashier|user'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Main');
    })->name('dashboard');
    Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin'])->group(function () {
        Route::prefix('/cashier')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Cashier/Show');
            })->name('cashier');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.cashier', ['users' => user::role('cashier')->get()])->download(Carbon\Carbon::now() . '_Cashier.pdf');
            })->name('cashier.pdf');
            Route::get('/excel', function () {
                $collection = user::role('cashier')->get(['name', 'email', 'created_at', 'updated_at'])->toArray();
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_Cashier.xlsx');
                foreach ($collection as $row) {
                    unset($row['profile_photo_url']);
                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('cashier.excel');
        });
        Route::prefix('/product')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Product/Show');
            })->name('product');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.product', ['products' => ProductController::getAll()])->download(Carbon\Carbon::now() . '_Product.pdf');
            })->name('product.pdf');
            Route::get('/excel', function () {
                $collection = ProductController::getAll()->toArray();
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_Product.xlsx');
                foreach ($collection as $row) {
                    unset($row['photo_url']);
                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('product.excel');
        });
    });
});

/**
 * This is a temporary solution for api until i have a proper solution.
 * this solution is not good because it is not microservice.
 */
Route::prefix('api')->group(function () {
    Route::middleware(['auth:sanctum', 'verified', 'role:manager|cashier'])->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::get('/cashier', function (Request $request) {
            if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
                $user = User::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('email', 'like', '%' . $request->query('search') . '%')->role('cashier');
                $count = $user->count();
                $userGet = $user->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalCashier' => $count,
                        'totalPages' => ceil($count / $request->query('size')),
                        'data' => $userGet,
                    ]
                );
            }
        });
    });
});
