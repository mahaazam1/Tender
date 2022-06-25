<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SavedProducts;
use Illuminate\Support\Facades\Auth;
class SavedProductsController extends Controller
{
    public function create(Request $request){

        $savedProduct = new SavedProducts;
        $savedProduct->user_id = Auth::guard('seller-api')->user()->id;
        $savedProduct->product_id = $request->product_id;

        $savedProduct->save();
        return response()->json([
            'success' => true,
            'message' => 'تم حفظ المنتج',
            'savedProduct' => $savedProduct
        ]);
    }


    public function delete(Request $request){
        $savedProduct = SavedProducts::find($request->id);
        
        if(Auth::guard('seller-api')->user()->id != $savedProduct->user_id){
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
        $SavedProducts = SavedProducts::where('user_id',Auth::guard('seller-api')->user()->id)->orderBy('id','desc')->get();
        return response()->json([
            'success' => true,
            'product' => $SavedProducts,
        ]);
    }
}
