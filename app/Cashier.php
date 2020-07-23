<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    protected $table = 'cashier';

    protected $fillable = [
        'cashier_name',

    ];

    public function carts()
    {
        return $this->hasMany('App\Cart', 'cashier_id');
    }
}
