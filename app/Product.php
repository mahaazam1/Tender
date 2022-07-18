<?php

namespace App;

use App\Category;
use App\User;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    public function user(){
    return $this->belongsTo(User::class);
   }

   public function category(){
    return $this->belongsTo('App\Category');
   }

   public function cart(){
    return $this->belongsTo('App\Cart');
   }

}
