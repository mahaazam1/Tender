<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    public function login(Request $request){
        $creds = $request->only(['email','password']);

        $token = Auth::guard('seller-api')->attempt($creds);

        if(!$token){

            return response()->json([
                 'success' => false,
                 'message' => 'invalid credintials'

            ]);
        }
        return response()->json([
            'success' =>true,
            'token' => $token,
            'user'  => Auth::guard('seller-api')->user()
        ]);
    }

    // public function login(Request $request){
    //     $creds = $request->only(['email','password']);

    //     if(!$token=auth()->attempt($creds)){

    //         return response()->json([
    //              'success' => false,
    //              'message' => 'invalid credintials'

    //         ]);
    //     }
    //     return response()->json([
    //         'success' =>true,
    //         'token' => $token,
    //         'user'  => Auth::user()
    //     ]);
    // }

    public function register(Request $request){
        $encryptedPass = Hash::make($request->password);
        $user = new User;

        try{
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = $encryptedPass;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = 'public/users/';
                $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
                Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
                $user->image = 'users/'.$nameImage;
            }
            $user->username = substr($request['email'], 0, strpos($request['email'], '@'));

            $user->craft_name = $request['craft_name'];
            $user->phone_number = $request['phone_number'];
            $user->save();

            return $this->login($request);  

        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }

    }

    public function userProfile(){
        return response()->json(auth()->guard('seller-api')->user());
    }

    public function updateProfile(Request $request){
        $user = User::find(Auth::guard('seller-api')->user()->id);
        
        $user->name = $request->name;
        $user->email = $user->email;
        $user->username = substr($user['email'], 0, strpos($user['email'], '@'));

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = 'public/users/';
            $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
            $user->image = 'users/'.$nameImage;
        }
        $user->craft_name = $request->craft_name;
        $user->phone_number = $request->phone_number;

        $user->update();
        return response()->json([
            'success' => true,
            'message' => 'تم تعديل البروفايل بنجاح'
        ]);
    }


    public function logout(){
        auth()->guard('seller-api')->logout();
        return response()->json(['message' => 'logout success']);
    }
}
