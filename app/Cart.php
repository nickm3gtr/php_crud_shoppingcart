<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  protected $table = 'cart';

  protected $fillable = [
    'cashier_id',
    'date_time'
  ];

  public function cashier()
  {
    return $this->belongsTo('App\Cashier', 'cashier_id');
  }

  public function item_carts()
  {
    return $this->hasMany('App\Item_Cart', 'cart_id');
  }
}
