<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PurchaseCart;
use App\SalesCart;
use App\Address;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseCartController extends Controller
{
    public function create(Request $request){
        $userId = Product::where('id',$request->product_id)->pluck('user_id');

        if($userId[0] == Auth::guard('seller-api')->user()->id){

            return response()->json([
                'success' => false,
                'message' => 'لا تستطيع اضافة منتجك الى السلة',
               
            ]);
        }
        $purchaseCart = new PurchaseCart;
        $purchaseCart->user_id = Auth::guard('seller-api')->user()->id;
        $purchaseCart->product_id = $request->product_id;
        $purchaseCart->quantity = $request->quantity;
 

        $purchaseCart->save();
        return response()->json([
            'success' => true,
            'message' => 'تمت اضافة المنتج الى السلة',
            'purchaseCart' => $purchaseCart,
        ]);
    }

    public function update(Request $request){
        $purchaseCart = PurchaseCart::find($request->id);
        // check if user is editing his own product
        // we need to check user id with product user id
        if(Auth::guard('seller-api')->user()->id != $purchaseCart->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $purchaseCart->product_id = $request->product_id;
        $purchaseCart->quantity = $request->quantity;
        $purchaseCart->update();
        return response()->json([
            'success' => true,
            'message' => 'cart edited'
        ]);
    }

    public function delete(Request $request){
        $purchaseCart = PurchaseCart::find($request->id);
        
        if(Auth::guard('seller-api')->user()->id != $purchaseCart->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $purchaseCart->delete();
        return response()->json([
            'success' => true,
            'message' => 'product deleted'
        ]);
    }

    public function purchaseCart(){
        // $purchaseCart = PurchaseCart::where('user_id',Auth::guard('seller-api')->user()->id)->orderBy('id','desc')->get();

        $purchaseCart = DB::table('purchase_carts')
        ->join('products','products.id','=','purchase_carts.product_id')
        ->where('purchase_carts.user_id','=',Auth::guard('seller-api')->user()->id)
        ->select('products.id','purchase_carts.id','products.name','products.image','products.price','products.description','purchase_carts.quantity')
        ->get();

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'product' => $purchaseCart,
        ]);
    }



    public function buying(){
        $purchaseCarts = PurchaseCart::where('user_id',Auth::guard('seller-api')->user()->id)->get();
       
        $address = Address::with('user')->where('user_id',Auth::guard('seller-api')->user()->id)->first();

        if($purchaseCarts->isEmpty()){

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

            foreach($purchaseCarts as $purchases){
                $sales = new SalesCart;
                $id = Product::where('id',$purchases->product_id)->select('user_id')->first();
                $sales->user_id = Auth::guard('seller-api')->user()->id;
                $sales->product_id = $purchases->product_id;
                $sales->quantity = $purchases->quantity;
                $sales->seller_id = $id['user_id'];
                $sales->save();
            }

            PurchaseCart::where('user_id',Auth::guard('seller-api')->user()->id)->delete();
            // $sale = SalesCart::where('user_id',Auth::guard('seller-api')->user()->id)->get();

            
            return response()->json([
                'success' => true,
                'message' => 'تم ارسال طلبك بنجاح',
                // 'address' => $address,
                // 'order' => $sale,
            ]);

        }
    }

    public function getMyOrder(){
        
        // $sale = SalesCart::with('product')->where('product_id',37)->where('user_id',Auth::guard('seller-api')->user()->id)->get();

    //     $salesCart = SalesCart::where('user_id',Auth::guard('seller-api')->user()->id)
    //     ->orderBy('created_at')->get()->groupBy(function($item) {
    //         return $item->created_at->format('Y-m-d');
    //    });

       $salesCart = DB::table('sales_carts')
        ->join('products','products.id','=','sales_carts.product_id')
        ->where('sales_carts.user_id','=',Auth::guard('seller-api')->user()->id)
        ->select('sales_carts.id','products.id','products.name','products.image','sales_carts.status',DB::raw('DATE(sales_carts.created_at) as date'))
        ->get()->groupBy('date');
        

        return response()->json([
            'success' => true,
            'my orders' => $salesCart,
        ]);

      
 
    }






}
