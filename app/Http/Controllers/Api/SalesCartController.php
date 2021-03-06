<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\SalesCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Address;
use App\BuyerAddress;  



class SalesCartController extends Controller
{
    
    public function getOrders(Request $request){
        $orders = SalesCart::where('seller_id', Auth::guard('seller-api')->user()->id)->get();
         $address  = [];
        foreach ($orders as $order) {

            if($order['user_id'] != null){

                array_push($address, Address::with('user')->where('user_id',$order['user_id'])->first());
            }
            if($order['buyer_id'] != null){

                array_push($address, BuyerAddress::with('buyer')->where('buyer_id',$order['buyer_id'])->first());
            }
        }

        $salesCart = DB::table('sales_carts')
        ->join('products','products.id','=','sales_carts.product_id')
        ->where('sales_carts.seller_id','=',Auth::guard('seller-api')->user()->id)
        ->select('products.id','products.name','products.description','products.image','sales_carts.status','sales_carts.user_id','sales_carts.buyer_id','sales_carts.quantity')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'You have '.count($salesCart) . ' orders',
            'order' => $salesCart,
            'address' => array_unique($address),
            
        ]);
    }

    public function orderCompleted(Request $request){
        $order = SalesCart::where('seller_id', Auth::guard('seller-api')->user()->id)->find($request->id);
        $order->status = 1;
        $order->update();

        return response()->json([
            'success' => true,
            'message' => 'اكتمل الطلب',
            'order' => $order,
            
        ]);

    } 
}
