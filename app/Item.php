<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    public function item_carts()
    {
        return $this->hasMany('App\Item_Cart', 'item_id');
    }
}
