<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    $validator = Validator::make($request->all(), [
      'cashier_id' => 'required',
      'date_time' => 'required'
    ]);

    if($validator->fails()) {
      return response()->json([
        'error' => true,
        'message' => 'Cart insert failed!'
      ], 422);
    } else {
      $cart = Cart::create($request->all());

      return response()->json([
        'error' => false,
        'message' => 'Cart added successfully!'
      ], 200);
    }
  }
}

