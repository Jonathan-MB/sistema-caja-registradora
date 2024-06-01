<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::post('/user/validateUser', [UserController::class,'validateUser'])->name('user.validateUser');
Route::get('/user', [UserController::class,'create'])->name('user.create');
Route::post('/user', [UserController::class,'store'])->name('user.store');

Route::get('/sale', [SaleController::class,'index'])->name('sale.index');
Route::get('/sale/info', [SaleController::class,'info'])->name('sale.info');
Route::get('/sale/create', [SaleController::class,'create'])->name('sale.create');
Route::post('/sales', [SaleController::class, 'store'])->name('sale.store');;

Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/product/check', [ProductController::class, 'check'])->name('product.check');
Route::get('/product/getPrice', [ProductController::class, 'getPrice'])->name('product.getPrice');
Route::get('/product/autocomplete', [ProductController::class, 'autocomplete'])->name('product.autocomplete');





// Manejo de rutas inexistentes  -----------------------------------------------------------------------------------------

Route::any('{fallbackPlaceholder?}', [FallbackController::class, 'fallback'])
    ->where('fallbackPlaceholder', '.*');

