<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Following; 
use App\Product;
class SellerController extends Controller
{
    public function getSellers(){
        $sellers = User::All();
        foreach($sellers as $seller){
            $seller['number of products'] = count(Product::where('user_id',$seller->id)->get());
            $seller['products'] = Product::where('user_id',$seller->id)->get();

            $seller['number of followers'] = count(Following::where('seller_id',$seller->id)->get());
            $seller['followers'] = Following::where('seller_id',$seller->id)->get();

            $seller['number of following'] = count($seller->followings);
            
        }
        return response()->json([
            'success' => true,
            'sellers' => $sellers,

        ]);

    }

    public function searchSeller(Request $request){
        $search = $request->search;
        $seller = User::with('product')->where('name','LIKE','%'.$search.'%')->get();

        if($seller->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'البائع غير موجود',
            ]);
        }

        return response()->json([
            'success' => true,
            'seller' => $seller
        ]);
    }

    public function newSellers(){
        $seller = User::with('product')->orderBy('created_at', 'DESC')->limit(5)->get();

        return response()->json([
            'success' => true,
            'products' => $seller
        ]);
    }

    public function mayLikeSellers(){
        $seller = User::with('product')->orderBy('created_at', 'Asc')->limit(5)->get();

        return response()->json([
            'success' => true,
            'products' => $seller
        ]);
    }
}
