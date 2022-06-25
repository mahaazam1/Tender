<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
class BuyerAddress extends Model
{
    public function buyer(){
        return $this->belongsTo(Buyer::class);

    }
}
