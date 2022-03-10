<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ShoppingCart extends Model
{
    protected $fillable = ['client_id', 'product_id', 'number_ofProduct', 'totalPrice', 'buy'];
    
    public function client(){
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }


    public function product(){
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

}
