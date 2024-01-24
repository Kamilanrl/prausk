<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/addToCart', [App\Http\Controllers\TransactionController::class, 'addToCart'])->name('addToCart');
Route::post('/payNow', [App\Http\Controllers\TransactionController::class, 'payNow'])->name('payNow');
Route::post('/topupNow', [App\Http\Controllers\WalletController::class, 'topupNow'])->name('topupNow');
Route::get('/download/{order_id}', [App\Http\Controllers\TransactionController::class, 'download'])->name('download');
Route::post('/acceptRequest', [App\Http\Controllers\WalletController::class, 'acceptRequest'])->name('acceptRequest');
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/transaction/{id}', [App\Http\Controllers\TransactionController::class, 'take'])->name('transaction.take');
Route::delete('/transaction/destroy{id}', [App\Http\Controllers\TransactionController::class, 'destroy'])->name('transaction.destroy');
Route::resource('/user', App\Http\Controllers\UserController::class);
