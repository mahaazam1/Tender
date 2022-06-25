<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BuyerAddress;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;

class AddressController extends Controller
{
    public function create(Request $request){
        $address = BuyerAddress::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
        if(count($address)>0){
            return response()->json([
                'status' => false,
                'message' => 'تم اضافة العنوان مسبقا'
            ]);
        }
        $address = new BuyerAddress;
        $address->buyer_id = Auth::guard('buyer-api')->user()->id;
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
    $address =  BuyerAddress::find($request->id);
    
    if(Auth::guard('buyer-api')->user()->id != $address->buyer_id){
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
        $address =  BuyerAddress::find($request->id);
        
        if(Auth::guard('buyer-api')->user()->id != $address->buyer_id){
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
        $address = BuyerAddress::where('buyer_id',Auth::guard('buyer-api')->user()->id)->get();
        return response()->json([
            'success' => true,
            'address' => $address,
            'user' => $user
        ]);
    }
}
