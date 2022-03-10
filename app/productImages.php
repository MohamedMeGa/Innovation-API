<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productImages extends Model
{
    
    protected $fillable = [
        'image', 'product_id',
    ];


    public function product(){
        return $this->belongsTo('App\Product', 'product_id', 'id');    //second param is foreign key, third param is primary key
    }
}
