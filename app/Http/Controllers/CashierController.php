<?php

namespace App\Http\Controllers;

use App\Cashier;
use App\Http\Resources\CashierResource;
use App\Http\Resources\CashierResourceCollection;
use Illuminate\Http\Request;

class CashierController extends Controller
{

    public function show(Cashier $cashier)
    {
        return (new CashierResource($cashier))->response()->setStatusCode(200);
    }

    public function index()
    {
        return (new CashierResourceCollection(Cashier::all()))->response()->setStatusCode(200);
    }

    public function store(Request $request)
    {
        $request->validate([
           'cashier_name' => 'required'
        ]);

        $cashier = Cashier::create($request->all());

        return (new CashierResource($cashier))->response()->setStatusCode(200);
    }
}
