<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
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

Route::resource('customer', CustomerController::class);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', [ItemController::class, 'index']);

Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::get('add-to-cart/{id}', [ItemController::class, 'addToCart'])->name('addToCart');
Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('shoppingCart');
Route::get('remove/{id}',[ItemController::class, 'removeItem'])->name('item.remove');
Route::get('reduce/{id}',[ItemController::class, 'getReduceByOne'])->name('item.reduceByOne');
Route::get('checkout',[ItemController::class, 'postCheckout'])->name('checkout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('/signup', [UserController::class, 'getSignup']);
    Route::post('/signup', [UserController::class, 'postSignup'])->name('user.signup');
    Route::get('profile', [UserController::class, 'getProfile' ])->name('user.profile')->middleware('auth');
    Route::view('/signin', 'user.signin');
    Route::post('/signin', [LoginController::class, 'postSignin'])->name('user.signin');
    Route::get('/logout',[LoginController::class,'getLogout'])->name('user.logout')->middleware('auth');
    Route::get('/order/{id}',[OrderController::class,'orderDetails'])->name('order.orderDetails')->middleware('auth');

});

Route::prefix('admin')->group(function () {
    Route::get('/orders',[OrderController::class,'orders'])->name('admin.orders')->middleware('auth');
    Route::get('/orders/{id}',[OrderController::class,'processOrder'])->name('admin.orderDetails');
    Route::post('/order/{id}', [OrderController::class, 'orderUpdate'])->name('admin.orderUpdate')->middleware('auth');
    Route::get('/users', [UserController::class, 'getUsers'])->name('admin.users')->middleware('auth');
});
