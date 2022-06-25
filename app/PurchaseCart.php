<?php

namespace App;
use App\Product;
use App\User;

use Illuminate\Database\Eloquent\Model;

class PurchaseCart extends Model
{
    public function product(){
        return $this->hasMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
