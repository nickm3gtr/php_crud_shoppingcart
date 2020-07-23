<?php

namespace App\Http\Controllers;

use App\Cashier;
use App\Http\Resources\CashierCollection;
use App\Http\Resources\CashierResource;

class CashierController extends Controller
{
    public function index()
    {
        return (new CashierCollection(Cashier::all()))->response()->setStatusCode(200);
    }

    public function show(Cashier $cashier)
    {
      return new CashierResource($cashier);
    }
}
