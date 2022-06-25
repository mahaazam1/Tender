<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;
use App\User;


class SavedProducts extends Model
{
    use SoftDeletes;

    public function product(){
        return $this->hasMany(Product::class);

    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
