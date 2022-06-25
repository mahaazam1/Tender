<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuyerSavedProducts;
use Illuminate\Support\Facades\Auth;

class SavedProductsController extends Controller
{
    public function create(Request $request){

        $savedProduct = new BuyerSavedProducts;
        $savedProduct->buyer_id = Auth::guard('buyer-api')->user()->id;
        $savedProduct->product_id = $request->product_id;
 
        $savedProduct->save();
        return response()->json([
            'success' => true,
            'message' => 'تم حفظ المنتج',
            'savedProduct' => $savedProduct
        ]);
    }


    public function delete(Request $request){
        $savedProduct = BuyerSavedProducts::find($request->id);
        
        if(Auth::guard('buyer-api')->user()->id != $savedProduct->buyer_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $savedProduct->delete();
        return response()->json([
            'success' => true,
            'message' => 'تمت ازالة العنصر من المحفوظات'
        ]);
    }

    public function savedProducts(){
        $SavedProducts = BuyerSavedProducts::where('buyer_id',Auth::guard('buyer-api')->user()->id)->orderBy('id','desc')->get();
        return response()->json([
            'success' => true,
            'product' => $SavedProducts,
        ]);
    }
}
