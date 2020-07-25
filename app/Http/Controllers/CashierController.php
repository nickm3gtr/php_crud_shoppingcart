<?php

namespace App\Http\Controllers;

use App\Cashier;
use App\Http\Resources\CashierCollection;
use App\Http\Resources\CashierResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
  public function index()
  {
    return (new CashierCollection(Cashier::all()))->response()->setStatusCode(200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required',
      'password' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'message' => 'Cashier insert failed!'
      ], 422);
    } else {
      $item = Cashier::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
      ]);

      return response()->json([
        'error' => false,
        'message' => 'Cashier added successfully!'
      ], 200);
    }
  }

  public function show(Cashier $cashier)
  {
    return new CashierResource($cashier);
  }
}
