<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index()
  {
    $cart = Cart::all();
    $cart = $cart->last();

    return (new CartResource($cart))->response()->setStatusCode(200);
  }


  public function store(Request $request)
  {
    $request->validate([
      'cashier_id' => 'required',
      'date_time' => 'required'
    ]);

    $cart = Cart::create($request->all());

    return response()->json([
      'error' => false,
      'message' => 'Cart added successfully!'
    ], 200);
  }
}

