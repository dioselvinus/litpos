<?php

use App\Http\Controllers\ProductController;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
Route::get('/cashier/pdf', function () {
    // return $pdf->download('cashier.pdf');
    // stream
    return PDF::loadView('pdf.table.cashier', ['users' => user::role('cashier')->get()])->download(Carbon\Carbon::now() . '_Cashier.pdf');
    // return $html;

})->name('cashier.pdf');

Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin|cashier'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Main');
    })->name('dashboard');
    Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin'])->group(function () {
        Route::get('/cashier', function () {
            return Inertia::render('Cashier/Show');
        })->name('cashier');
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
            if ($request->query('search')) {
                $user = User::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('email', 'like', '%' . $request->query('search') . '%')->role('cashier');
                if (ceil($user->count() / $request->query('size'))) {
                    $userGet = $user->skip($request->query('page'))->take($request->query('size'))->get();
                } else {
                    $userGet = $user->get();
                }
                return response()->json(
                    [
                        'totalCashier' => $user->count(),
                        'totalPages' => ceil($user->count() / $request->query('size')),
                        'data' => $userGet,
                    ]
                );
            } else {
                $user = User::role('cashier')->skip($request->query('page'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalCashier' => User::role('cashier')->count(),
                        'totalPages' => ceil(User::role('cashier')->count() / $request->query('size')),
                        'data' => $user,
                    ]
                );
            }
        });
    });
});
