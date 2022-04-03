<?php

use App\Http\Controllers\ProductController;
use App\Http\Services\Checkout\CheckoutService as Service;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
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

require __DIR__ . '/jetstream.php';

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin|employee|user'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Main');
    })->name('dashboard');

    Route::middleware(['auth:sanctum', 'verified', 'role:employee'])->group(function () {
        Route::get('/transactions', function () {
            return Inertia::render('Transactions/Show');
        })->name('transactions');

        Route::get('kitchen', function () {
            return Inertia::render('Kitchen/Show');
        })->name('kitchen');
    });

    Route::middleware(['auth:sanctum', 'verified', 'role:employee|manager|admin'])->group(function () {
        Route::prefix('/history')->group(function () {
            Route::get('/', function () {
                return Inertia::render('History/Show');
            })->name('history');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.history', ['transaction' => Transaction::latest()->with('user')->get()])->download(Carbon\Carbon::now() . '_History.pdf');
            })->name('history.pdf');
            Route::get('/excel', function () {
                $collection = Transaction::latest()->with('user')->get()->toArray();
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_History.xlsx');
                foreach ($collection as $row) {
                    unset($row['user_id']);
                    if (isset($row['user'])) {
                        $row['user'] = $row['user']['name'];
                    }
                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('history.excel');
        });
    });

    Route::middleware(['auth:sanctum', 'verified', 'role:manager|admin'])->group(function () {

        Route::prefix('/employee')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Employee/Show');
            })->name('employee');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.employee', ['users' => user::role('employee')->get()])->download(Carbon\Carbon::now() . '_Employee.pdf');
            })->name('employee.pdf');
            Route::get('/excel', function () {
                $collection = user::role('employee')->get(['name', 'email', 'created_at', 'updated_at'])->toArray();
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_Employee.xlsx');
                foreach ($collection as $row) {
                    unset($row['profile_photo_url']);
                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('employee.excel');
        });

        Route::prefix('/product')->group(function () {
            Route::get('/', function () {
                return Inertia::render('Product/Show');
            })->name('product');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.product', ['products' => Product::all()])->download(Carbon\Carbon::now() . '_Product.pdf');
            })->name('product.pdf');
            Route::get('/excel', function () {
                $collection = Product::get(['name', 'category', 'price', 'status', 'created_at', 'updated_at'])->toArray();
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_Product.xlsx');
                foreach ($collection as $row) {
                    if ($row['price']) {
                        $row['price'] = number_format($row['price'], 2, ',', '.');
                    }

                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('product.excel');

            Route::get('/create', function () {
                return Inertia::render('Product/Create');
            })->name('product.create');
            Route::get('/{product}/edit', function (Product $product) {
                return Inertia::render('Product/Edit', [
                    'product' => $product,
                ]);
            })->name('product.edit');
        });

    });

    Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {
        Route::prefix('/user')->group(function () {
            Route::get('/', function () {
                return Inertia::render('User/Show');
            })->name('user');
            Route::get('/pdf', function () {
                return PDF::loadView('pdf.table.user', ['users' => User::with('roles')->role(['employee', 'manager'])->get()])->download(Carbon\Carbon::now() . '_User.pdf');
            })->name('user.pdf');
            Route::get('/excel', function () {
                $collection = User::with('roles')->role(['employee', 'manager'])->get()->toArray(); //['name', 'email', 'created_at', 'updated_at']
                $excel = SimpleExcelWriter::streamDownload(Carbon\Carbon::now() . '_User.xlsx');
                foreach ($collection as $row) {
                    $row['role'] = $row['roles'][0]['name'];
                    unset($row['roles'], $row['id'], $row['email_verified_at'], $row['current_team_id'], $row['profile_photo_path'], $row['deleted_at'], $row['profile_photo_url']);
                    $excel->addRow($row);
                }
                return $excel->toBrowser();
            })->name('user.excel');
        });
    });
});

/**
 * This is a temporary solution for api until i have a proper solution.
 * this solution is not good because it is not microservice.
 */
Route::prefix('api')->group(function () {
    // test sandbox qrcode pay
    Route::get('/transactions/{transaction}/pay', function (Transaction $transaction) {

        $service = new Service();
        $service->payQRCode($transaction->id);

        $transaction->status = 'success';
        $transaction->save();
        return redirect('/');
    })->name('transactions.pay');

    Route::middleware(['auth:sanctum', 'verified', 'role:manager|employee|admin'])->group(function () {

        /** api for dashboard */

        // table with apex chart
        Route::get('/sales/user', function () {
            // get employee with sales in this year
            $employees = User::whereYear('created_at', Carbon\Carbon::now()->year)->role('employee')->with('transactions')->get();
            foreach ($employees as $employee) {
                $months = [];
                for ($i = 1; $i <= 12; $i++) {
                    $months[$i] = 0;
                }
                $sum = 0;
                foreach ($employees as $employee) {
                    $months[$employee->created_at->month] += $employee->transactions->where('status', 'success')->count();
                    foreach ($employee->transactions->where('status', 'success') as $transaction) {
                        $sum += $transaction->total;
                    }
                }

                $employee->transaction = [
                    'data' => [['name' => "Transaction", 'data' => array_values($months)]],
                    'sum' => 'Rp ' . number_format($sum, 2, ',', '.'),
                ];
            }
            return $employees;
        });
        // apex chart
        Route::get('/sales', function () {
            $transactions = Transaction::whereYear('created_at', Carbon\Carbon::now()->year)->where('status', 'success')->get();
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = 0;
            }
            foreach ($transactions as $transaction) {
                $months[$transaction->created_at->month] += $transaction->total;
            }
            $sum = 'Rp ' . number_format(array_sum($months), 2, ',', '.');

            return [
                'sales' => [['name' => "Sales", 'data' => array_values($months)]],
                'sum' => $sum,
            ];
        });
        // apex chart
        Route::get('card/user', function () {
            // transaction success in this year and save to array 12 months
            $transactions = User::whereYear('created_at', Carbon\Carbon::now()->year)->get();
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = 0;
            }
            foreach ($transactions as $transaction) {
                $months[$transaction->created_at->month] += 1;
            }

            return [
                'data' => [['name' => "User", 'data' => array_values($months)]],
                'title' => $transactions->count() . ' Users',
            ];
        });
        // apex chart
        Route::get('card/produk', function () {
            // transaction success in this year and save to array 12 months
            $transactions = Product::whereYear('created_at', Carbon\Carbon::now()->year)->get();
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = 0;
            }
            foreach ($transactions as $transaction) {
                $months[$transaction->created_at->month] += 1;
            }

            return [
                'data' => [['name' => "Product", 'data' => array_values($months)]],
                'title' => $transactions->count() . ' Product',
            ];
        });
        // financial
        Route::get('/transactions/hot', function () {
            return Transaction::latest()->limit(5)->with('user')->get()->toArray();
        });
        // financial overview
        Route::get('/transactions/sum', function () {
            return ['success' => Transaction::where('status', 'success')->sum('total'), 'failed' => Transaction::where('status', 'failed')->sum('total'), 'pending' => Transaction::where('status', 'pending')->sum('total')];
        });
        /* end api for dashboard */

        // create transaction
        Route::post('/transactions/new', function (Request $request) {
            $service = new Service();
            if (!session('qr_transaction')) {
                session(['qr_transaction' => $service->createQRCode(['amount' => $request->amount])]);
            }
            try {
                Transaction::create([
                    'id' => session('qr_transaction')['external_id'],
                    'user_id' => $request->user()->id,
                    'subtotal' => $request->amount,
                    'ppn' => ceil($request->amount * 0.1),
                    'total' => $request->amount + ceil($request->amount * 0.1),
                    'order' => $request->order,
                    'status' => 'pending',
                ]);
            } catch (\Exception$e) {
                if ($e->getCode() == 23000) {
                    $id = session('qr_transaction')['external_id'];
                    session()->forget('qr_transaction');
                    session(['qr_transaction' => $service->createQRCode(['amount' => $request->amount])]);
                    // delete transactionProduct by transaction id
                    TransactionProduct::where('transaction_id', $id)->delete();
                    Transaction::find($id)->update(['id' => session('qr_transaction')['external_id'], 'user_id' => $request->user()->id, 'subtotal' => $request->amount, 'ppn' => ceil($request->amount * 0.1), 'total' => $request->amount + ceil($request->amount * 0.1), 'status' => 'pending', 'order' => $request->order]);
                    foreach (array_values($request->basket) as $item) {
                        TransactionProduct::insert([
                            'id' => Uuid::uuid4()->toString(),
                            'transaction_id' => session('qr_transaction')['external_id'],
                            'product_id' => $item['product']['id'],
                            'quantity' => $item['quantity'],
                        ]);
                    }
                    return session('qr_transaction');
                }
            }
            foreach (array_values($request->basket) as $item) {
                TransactionProduct::insert([
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => session('qr_transaction')['external_id'],
                    'product_id' => $item['product']['id'],
                    'quantity' => $item['quantity'],
                ]);
            }
            return session('qr_transaction');
        })->name('transactions.new');

        // transactions update qrcode
        Route::post('/transactions/{transaction}/check', function (Transaction $transaction) {
            if ($transaction->status == 'success') {
                session()->forget('qr_transaction');
            }
            return $transaction->status;
        })->name('transactions.show');
        // transactions submit cash
        Route::post('/transactions/{transaction}/submit', function (Transaction $transaction, Request $request) {
            $transaction->update([
                'status' => 'success',
                'cash_amount' => $request->cash_amount,
                'cash_change' => $request->cash_amount - $transaction->total,
                'payment_method' => 'cash',
            ]);
            session()->forget('qr_transaction');
            return $transaction;
        })->name('transactions.submit');
        // transactions canceled
        Route::post('/transactions/{transaction}/cancel', function (Transaction $transaction) {
            $transaction->status = 'failed';
            $transaction->save();
            session()->forget('qr_transaction');
            return $transaction;
        })->name('transactions.cancel');

        // table history
        Route::get('/transactions', function (Request $request) {
            if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
                $transaction = Transaction::latest()->where('status', 'like', '%' . $request->query('search') . '%')->orWhere('id', 'like', '%' . $request->query('search') . '%')->with('user');
                $count = $transaction->count();
                $transactionGet = $transaction->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalTransaction' => $count,
                        'totalPages' => ceil($count / $request->query('size')),
                        'data' => $transactionGet,
                    ]
                );
            }
        });
        Route::apiResource('products', ProductController::class);
        // get user only role employee
        Route::get('/employee', function (Request $request) {
            if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
                $user = User::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('email', 'like', '%' . $request->query('search') . '%')->role('employee');
                $count = $user->count();
                $userGet = $user->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalEmployee' => $count,
                        'totalPages' => ceil($count / $request->query('size')),
                        'data' => $userGet,
                    ]
                );
            }
        });
        // get user had roles
        Route::get('/user', function (Request $request) {
            if (empty($request->all())) {
                return response()->json(User::with('roles')->role(['employee', 'manager'])->get());
            }
            if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
                $user = User::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('email', 'like', '%' . $request->query('search') . '%')->role(['employee', 'manager'])->with('roles');
                $count = $user->count();
                $userGet = $user->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalUser' => $count,
                        'totalPages' => ceil($count / $request->query('size')),
                        'data' => $userGet,
                    ]
                );
            }
        });
        // delete user
        Route::delete('/user/{user}', function (User $user) {
            $user->delete();
        });
        // change role user
        Route::put('/user/{user}', function (Request $request, User $user) {
            $user->removeRole($user->roles->first());
            $user->assignRole(Str::lower($request->roles));
        })->name('user.update');

        // table registered user
        Route::get('/user/new', function (Request $request) {
            if (empty($request->all())) {
                return response()->json(User::with('roles')->role(['user'])->get());
            }
            if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
                $user = User::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('email', 'like', '%' . $request->query('search') . '%')->role(['user'])->with('roles');
                $count = $user->count();
                $userGet = $user->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
                return response()->json(
                    [
                        'totalUser' => $count,
                        'totalPages' => ceil($count / $request->query('size')),
                        'data' => $userGet,
                    ]
                );
            }
        });
    });
});
