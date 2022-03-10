<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function images(){
        return $this->hasMany('App\productImages', 'product_id');    //second param is foreign key
    }

    public function category(){
        return $this->belongsTo('App\Category', 'categpry_id', 'id');    //second param is foreign key, thisd param is primary key
    }

    public function shoppingCarts(){
        return $this->hasMany('App\ShoppingCart', 'product_id');
    }
}
