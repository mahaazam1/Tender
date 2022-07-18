<?php

namespace App\Http\Controllers\Api\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Buyer;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        $encryptedPass = Hash::make($request->password);
        $buyer = new Buyer;

        try{
            $buyer->name = $request['name'];
            $buyer->email = $request['email'];
            $buyer->password = $encryptedPass;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = 'public/users/';
                $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
                $buyer->image = 'users/'.$nameImage;
            }
            $buyer->username = substr($request['email'], 0, strpos($request['email'], '@'));
            $buyer->phone_number = $request['phone_number'];
            $buyer->save();

            return $this->login($request);  
            

        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }

    }

    public function login(Request $request){
        $creds = $request->only(['email','password']);

        $token = Auth::guard('buyer-api')->attempt($creds);

        if(!$token){

            return response()->json([
                 'success' => false,
                 'message' => 'invalid credintials'

            ]);
        }
        return response()->json([
            'success' =>true,
            'token' => $token,
            'buyer'  => Auth::guard('buyer-api')->user()
        ]);
    }

    public function profile(){
        return response()->json(auth()->guard('buyer-api')->user());
    }

    public function updateProfile(Request $request){
        $buyer = Buyer::find(Auth::guard('buyer-api')->user()->id);
        
        $buyer->name = $request->name;
        $buyer->email = $buyer->email;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = 'public/users/';
            $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
            $buyer->image = 'users/'.$nameImage;
        }
        $buyer->username = substr($buyer['email'], 0, strpos($buyer['email'], '@'));
        $buyer->phone_number = $request->phone_number;

        $buyer->update();
        return response()->json([
            'success' => true,
            'message' => 'تم تعديل البروفايل بنجاح'
        ]);
    }

    public function logout(){
        auth()->guard('buyer-api')->logout();
        return response()->json(['message' => 'logout success']);
    }
}
