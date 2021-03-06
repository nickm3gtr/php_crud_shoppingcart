<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('/cashier', 'CashierController');
Route::middleware(['auth:api'])->group(function () {
  Route::apiResource('/item', 'ItemController');
  Route::apiResource('/cart', 'CartController');
  Route::apiResource('/item_cart', 'ItemCartController');
  Route::apiResource('/transaction', 'TransactionController');
  Route::get('/cashier-current', 'CashierController@showLoggedCashier');
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@login');
