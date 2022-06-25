<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Buyer;

class BuyerSavedProducts extends Model
{
    public function product(){
        return $this->hasMany(Product::class);

    }
    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }
}
