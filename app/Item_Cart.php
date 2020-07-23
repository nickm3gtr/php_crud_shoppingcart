<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Cart extends Model
{
    protected $table = 'item_cart';

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function cart()
    {
        return $this->belongsTo('App\Cart', 'cart_id');
    }
}
