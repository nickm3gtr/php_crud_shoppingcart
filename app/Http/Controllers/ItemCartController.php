<?php

namespace App\Http\Controllers;

use App\Item_Cart;
use Illuminate\Http\Request;

class ItemCartController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'item_id' => 'required',
      'cart_id' => 'required',
      'item_qty' => 'required'
    ]);

    $item_cart = Item_Cart::create($request->all());

    return response()->json([
      'error' => false,
      'message' => 'Item_cart added successfully!'
    ], 200);
  }
}
