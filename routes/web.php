<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductGalleryController;

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

// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontendController::class, 'details'])->name('details');

// cart
Route::middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
        Route::post('/cart/{id}', [FrontendController::class, 'cartAdd'])->name('cart-add');
        Route::delete('/cart/{id}', [FrontendController::class, 'cartDelete'])->name('cart-delete');
        Route::get('/checkout/success', [FrontendController::class, 'success'])->name('checkout-success');
    });

// Backend
Route::middleware(['auth:sanctum', 'verified'])
    ->name('dashboard.')
    ->prefix('dashboard')
    ->group(function () {
        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::middleware(['admin'])->group(function () {
            Route::resource('product', ProductController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow();
            Route::resource('transaction', TransactionController::class);
            Route::resource('transaction', TransactionController::class);
            Route::resource('user', UserController::class);
        });
    });
