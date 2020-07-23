<?php

namespace App\Http\Controllers;

use App\Item_Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemCartController extends Controller
{
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'item_id' => 'required',
      'cart_id' => 'required',
      'item_qty' => 'required'
    ]);

    if($validator->fails()) {
      return response()->json([
        'error' => true,
        'message' => 'Item_Cart insert failed!'
      ], 422);
    } else {
      $item_cart = Item_Cart::create($request->all());

      return response()->json([
        'error' => false,
        'message' => 'Item_cart added successfully!'
      ], 200);
    }
  }
}
