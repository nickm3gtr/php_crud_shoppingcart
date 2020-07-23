<?php

namespace App\Http\Controllers;

use App\Cashier;
use App\Http\Resources\CashierCollection;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index()
    {
        return (new CashierCollection(Cashier::all()))->response()->setStatusCode(200);
    }
}
