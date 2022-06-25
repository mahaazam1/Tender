<?php

namespace App;
use App\Product;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product(){
        return $this->hasMany(Product::class);
    }

    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }
}
