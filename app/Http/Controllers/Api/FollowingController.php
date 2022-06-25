<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Following;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Buyer;

class FollowingController extends Controller
{ 
    public function follow(Request $request){

        if(Auth::guard('seller-api')->check()){
            $follow = Following::where('seller_id',$request->seller_id)->where('user_id',Auth::guard('seller-api')->user()->id)->get();
            if(count($follow)>0){
                $follow[0]->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'unfollow'
                ]);
            }
            $follow = new Following;
            $follow->user_id = Auth::guard('seller-api')->user()->id;
            $follow->seller_id = $request->seller_id;
            $follow->save();
    
            return response()->json([
                'status' => true,
                'message' => 'follow',
                'follow' => $follow
            ]);

        }
        elseif(Auth::guard('buyer-api')->check()){

            $follow = Following::where('seller_id',$request->seller_id)->where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
            if(count($follow)>0){
                $follow[0]->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'unfollow'
                ]);
            }
            $follow = new Following;
            $follow->buyer_id = Auth::guard('buyer-api')->user()->id;
            $follow->seller_id = $request->seller_id;
            $follow->save();

            return response()->json([
                'status' => true,
                'message' => 'follow',
                'follow' => $follow
            ]);
        }
    }

    public function following(Request $request){
        $sellerFollowings  = [];
        if(Auth::guard('seller-api')->check()){

            $followings = Following::where('user_id',Auth::guard('seller-api')->user()->id)->get();

            foreach ($followings as $following){
                array_push($sellerFollowings,User::where('id',$following->seller_id)->first());
            }

            return response()->json([
                'status' => true,
                'sellerFollowings' => $sellerFollowings
            ]);

        }elseif(Auth::guard('buyer-api')->check()){

                $buyerFollowings  = [];
                $followings = Following::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
    
                foreach ($followings as $following){
                    array_push($buyerFollowings,User::where('id',$following->seller_id)->first());
                }
    
                return response()->json([
                    'status' => true,
                    'buyerFollowings' => $buyerFollowings
                ]);

        }
    }

    public function followers(Request $request){

        $followers = Following::where('seller_id',Auth::guard('seller-api')->user()->id)->get();
        
        $users  = [];
        foreach ($followers as $follower){

            if($follower['user_id'] != null){
                array_push($users,User::where('id',$follower->user_id)->first());
            }
            if($follower['buyer_id'] != null){
                array_push($users,Buyer::where('id',$follower->buyer_id)->first());
            }
        }
        
        return response()->json([
            'status' => true,
            'followersCount' => count($users),
            'followers' => $users, 
        ]);
    }   




    // public function follow(Request $request){
    //     $follow = Following::where('seller_id',$request->seller_id)->where('user_id',Auth::guard('seller-api')->user()->id)->get();
    //     //check if it returns 0 then this post is not liked and should be liked else unliked
    //     if(count($follow)>0){
    //         //bcz we cant have likes more than one
    //         $follow[0]->delete();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'unfollow'
    //         ]);
    //     }
    //     $follow = new Following;
    //     $follow->user_id = Auth::guard('seller-api')->user()->id;
    //     $follow->seller_id = $request->seller_id;
    //     $follow->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'follow',
    //         'follow' => $follow
    //     ]);
    // }

    // public function following(Request $request){
    //     $followings = Following::where('user_id',Auth::guard('seller-api')->user()->id)->get();


    //     $users  = [];
    //     foreach ($followings as $following){
    //         array_push($users,User::where('id',$following->seller_id)->first());
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'followings' => $users
    //     ]);
    // }

    // public function followers(Request $request){
    //     $followers = Following::where('seller_id',Auth::guard('seller-api')->user()->id)->get();
        
    //     $users  = [];
    //     foreach ($followers as $follower){
    //         array_push($users,User::where('id',$follower->user_id)->first());
    //     }
        
    //     return response()->json([
    //         'status' => true,
    //         'followers' => $users
    //     ]);
    // }
}
