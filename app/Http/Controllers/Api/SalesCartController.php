<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\SalesCart;
use Illuminate\Support\Facades\Auth;
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
        
/*
        $orders = DB::table('sales_carts')
        ->join('users','users.id','=','sales_carts.user_id')
        ->join('addresses','addresses.user_id','=','users.id')
        ->where('sales_carts.seller_id','=',Auth::guard('seller-api')->user()->id)
        ->get();
*/
        
        return response()->json([
            'success' => true,
            'message' => 'You have '.count($orders) . ' orders',
            'order' => $orders,
            'address' => $address,
            
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
