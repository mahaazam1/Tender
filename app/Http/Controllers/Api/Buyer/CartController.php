<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\SalesCart;
use App\BuyerAddress;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class CartController extends Controller
{
    public function create(Request $request){

        $cart = new Cart;
        $cart->buyer_id = Auth::guard('buyer-api')->user()->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;


        $cart->save();
        return response()->json([
            'success' => true,
            'message' => 'تم اضافة المنتج الى السلة',
            'cart' => $cart
        ]);
    }

    public function update(Request $request){
        $cart = Cart::find($request->id);
       
        if(Auth::guard('buyer-api')->user()->id != $cart->buyer_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->update();
        return response()->json([
            'success' => true,
            'message' => 'cart edited'
        ]);
    }

    public function delete(Request $request){
        $cart = Cart::find($request->id);
        
        if(Auth::guard('buyer-api')->user()->id != $cart->buyer_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $cart->delete();
        return response()->json([
            'success' => true,
            'message' => 'تم ازالة المنتج من السلة'
        ]);
    }

    public function cart(){
        $cart = Cart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
        return response()->json([
            'success' => true,
            'product' => $cart,
        ]);
    }

    public function buying(){
        $carts = Cart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
        $address = BuyerAddress::with('buyer')->where('buyer_id',Auth::guard('buyer-api')->user()->id)->first();

        if($carts->isEmpty()){

            return response()->json([
                'success' => false,
                'message' => 'أضف المنتجات التي تريد شرائها الى السلة',
            ]);

        }
        if($address == null){

            return response()->json([
                'success' => false,
                'message' => '!اضف عنوانك قبل الطلب'
            ]);

        }else{

            foreach($carts as $purchases){
                $sales = new SalesCart;

                $id = Product::where('id',$purchases->product_id)->select('user_id')->first();
    
                $sales->buyer_id = Auth::guard('buyer-api')->user()->id;
                $sales->product_id = $purchases->product_id;
                $sales->quantity = $purchases->quantity;
                $sales->seller_id = $id['user_id'];

                $sales->save();
            }

            
            Cart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->delete();
            // $sale = SalesCart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();

            return response()->json([
                'success' => true,
                'message' => 'تم ارسال طلبك بنجاح',
                
            ]);

        }
    }

    public function getMyOrder(){

        //  $salesCart = SalesCart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();

        $salesCart = SalesCart::where('buyer_id',Auth::guard('buyer-api')->user()->id)->orderBy('created_at')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
       });
        return response()->json([
            'success' => true,
            'my order' => $salesCart,
        ]);

    }
}
