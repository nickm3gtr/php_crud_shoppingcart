<?php

use Illuminate\Support\Facades\Route;

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
  return view('cart.index');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cashiers', function () {
  return view('cashiers.index');
})->middleware('auth');

Route::get('/items', function () {
  return view('items.index');
})->middleware('auth');

Route::get('/cart', function () {
  return view('cart.index');
})->middleware('auth');

Route::get('/transactions', function () {
  return view('transactions.index');
})->middleware('auth');
