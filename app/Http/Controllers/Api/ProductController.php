<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function create(Request $request){

        $product = new Product;
        $product->user_id = Auth::guard('seller-api')->user()->id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->name = $request->name;
        $product->price = $request->price;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = 'public/products/';
            $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
            $product->image = 'products/'.$nameImage;
        }
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'تم ارسال طلبك بنجاح.. سيتم مراجعته وادراجه',
        ]);
    }

    public function update(Request $request){
        $product = Product::find($request->id);
        
        if(Auth::guard('seller-api')->user()->id != $product->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->name = $request->name;
        $product->price = $request->price;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = 'public/products/';
            $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
            $product->image = 'products/'.$nameImage;
        }
        $product->update();
        return response()->json([
            'success' => true,
            'message' => 'product edited'
        ]);
    }

    public function delete(Request $request){
        $product = Product::find($request->id);
        if(Auth::guard('seller-api')->user()->id != $product->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        if($product->image != ''){
            Storage::delete('public/products/'.$product->image);
        }

        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'product deleted'
        ]);
    }

    public function products(){
        $products = Product::with('category')->where('status',1)->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function myProducts(){
        $products = Product::with('category')->where('status',1)
        ->where('user_id',Auth::guard('seller-api')->user()->id)->orderBy('id','desc')->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'product' => $products,
            'user' => $user
        ]);
    }

    public function lastProducts(){
        $products = Product::with('category')->orderBy('created_at', 'DESC')->limit(5)->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    } 

    public function productsOffers(){
        $products = Product::with('category')->where('price','<',10)->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function searchProduct(Request $request){
        $search = $request->search;
        $product = Product::with('category')->where('name','LIKE','%'.$search.'%')->get();

        if($product->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود',
            ]);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

}
