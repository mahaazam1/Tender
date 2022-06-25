<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;

class AddressController extends Controller
{
    public function create(Request $request){
        $address = Address::where('user_id',Auth::guard('seller-api')->user()->id)->get();
        if(count($address)>0){
            return response()->json([
                'status' => false,
                'message' => 'تم اضافة العنوان مسبقا'
            ]);
        }
        $address = new Address;
        $address->user_id = Auth::guard('seller-api')->user()->id;
        //chooes city
        $address->city_name = $request->city_name;
        $address->area_name = $request->area_name;
        $address->street_name = $request->street_name;
        $address->detailed_address = $request->detailed_address;

        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'تمت اضافة العنوان',
            'address' => $address
        ]);
        
}

public function update(Request $request){
    $address =  Address::find($request->id);
    
    if(Auth::guard('seller-api')->user()->id != $address->user_id){
        return response()->json([
            'success' => false,
            'message' => 'لا يوجد لديك صلاحيات '
        ]);
    }
        
        $address->city_name = $request->city_name;
        $address->area_name = $request->area_name;
        $address->street_name = $request->street_name;
        $address->detailed_address = $request->detailed_address;

        $address->update();

        return response()->json([
            'success' => true,
            'message' => 'تم التعديل بنجاح',
            'product' => $address
        ]);       
}

    public function delete(Request $request){
        $address =  Address::find($request->id);
        
        if(Auth::guard('seller-api')->user()->id != $address->user_id){
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد لديك صلاحيات '
            ]);
        }

            $address->delete();
            return response()->json([
                'success' => true,
                'message' => 'تم الحذف بنجاح',
            ]);       
    }

    public function myAddress(){
        $address = Address::where('user_id',Auth::guard('seller-api')->user()->id)->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'address' => $address,
            'user' => $user
        ]);
    }



}


