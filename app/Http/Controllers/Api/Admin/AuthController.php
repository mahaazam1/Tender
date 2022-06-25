<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Admin;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function loginAdmin(Request $request){
        $creds = $request->only(['email','password']);

        $token = auth()->guard('admin-api')->attempt($creds);

        if(!$token){

            return response()->json([
                 'success' => false,
                 'message' => 'invalid credintials'

            ]);
        }
        return response()->json([
            'success' =>true,
            'token' => $token,
            'admin'  => Auth::guard('admin-api')->user()
        ]);
    }

    public function registerAdmin(Request $request){
        $encryptedPass = Hash::make($request->password);
        $admin = new Admin;

        try{
            $admin->name = $request['name'];
            $admin->email = $request['email'];
            $admin->password = $encryptedPass;
          
            $admin->save();

            return response()->json([
                'admin' => $admin,
                'success' => true
            ]);

        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }

    }

    // public function logout(Request $request){
    //     try{
    //        JWTAuth::invalidate(JWTAuth::parseToken($request->token));
    //        return response()->json([
    //             'success' => true,
    //             'message' => 'logout success'
    //         ]);

    //     }
    //     catch(Exception $e){
    //         return response()->json([
    //             'success' => false,
    //             'message' => ''.$e
    //         ]);
    //     }
    // }

    // public function profile(){
    //     return Auth::user();
    // }

    public function profileAdmin(){
        return response()->json(auth()->guard('admin-api')->user());
    }

    public function logoutAdmin(){
        auth()->guard('admin-api')->logout();
        return response()->json(['message' => 'logout success']);
    }

}
