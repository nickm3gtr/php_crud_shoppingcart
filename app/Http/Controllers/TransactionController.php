<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Cashier;
use App\Http\Resources\TransactionCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  public function index()
  {
    $transactions = DB::table('cart')
      ->join('cashier', 'cart.cashier_id', '=', 'cashier.id')
      ->select('cart.id', 'cashier.name', 'cart.date_time')
      ->orderBy('cart.id', 'desc')
      ->get()
      ->toArray();

    return response()->json([
      'data' => $transactions
    ], 200);
  }

  public function show($id)
  {
    $transaction = DB::table('cashier')
      ->rightJoin('cart', 'cashier.id', '=', 'cart.cashier_id')
      ->rightJoin('item_cart', 'cart.id', '=', 'item_cart.cart_id')
      ->leftJoin('item', 'item_cart.item_id', '=', 'item.id')
      ->select('cart.id', 'cashier.name', 'cart.date_time', 'item.item_name', 'item.item_price', 'item_cart.item_qty')
      ->where('cart.id', $id)
      ->get()
      ->toArray();

    return response()->json([
      'data' => $transaction
    ], 200);
  }
}
