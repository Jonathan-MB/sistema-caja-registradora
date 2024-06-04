<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

// creacion de rutas independientes


Route::get('/user', [UserController::class,'inicio'])->name('user.validateUser');
Route::post('/user/validateUser', [UserController::class,'validateUser'])->name('user.validateUser');
Route::get('/sale/info', [SaleController::class,'info'])->name('sale.infor');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/product/check', [ProductController::class, 'check'])->name('product.check');
Route::get('/product/getPrice', [ProductController::class, 'getPrice'])->name('product.getPrice');


Route::get('/user', [UserController::class,'create'])->name('user.create');
Route::post('/user', [UserController::class,'store'])->name('user.store');

Route::get('/sale', [SaleController::class,'index'])->name('sale.index');
Route::get('/sale/create', [SaleController::class,'create'])->name('sale.create');
Route::post('/sale/store', [SaleController::class,'store'])->name('sale.store');



Route::resources([

    'product' => ProductController::class,

    'sale' => SaleController::class,

    // generacion de rutas para rols
    'saleDetail' => SaleDetailController::class,

    // generacion de rutas para states
    'type' => TypeController::class,

    // generacion de rutas para visibility
    'user' => UserController::class
]);




// Manejo de rutas inexistentes  -----------------------------------------------------------------------------------------

Route::any('{fallbackPlaceholder?}', [FallbackController::class, 'fallback'])
    ->where('fallbackPlaceholder', '.*');

