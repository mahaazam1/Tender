<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
 
class ProductController extends Controller
{
    public function index(){
        $paginate = 6;
        $products = Product::with('category')->where('status',0)->paginate($paginate);
        $users = User::all();

        return view('admin.products.index')->with('products',$products)->with('users',$users);
    } 

    public function destroy($id){

        Product::where("id",$id)->delete();
        return redirect()->back();
    }

    public function approvalProduct($id){
        $product = Product::where("id",$id)->first();
        $product->status = 1;
        $product->update();

        return redirect()->back();

    }

    public function allProducts(){
        $paginate = 6;
        $products = Product::withTrashed()->select('*')->paginate($paginate);
        // $products = Product::onlyTrashed()->select('*')->get();
        $users = User::all();


        return view('admin.products.all')->with('products',$products)->with('users',$users);

    }
    
    public function acceptedProducts(){
        $paginate = 6;
        $products = Product::with('category')->where('status',1)->paginate($paginate);
        $users = User::all();
        
        return view('admin.products.accepted')->with('products',$products)->with('users',$users);
    }

    public function searchProduct(Request $request){
 
        $search = $request['search'];
        $products = Product::with('category')->where('name','LIKE','%'.$search.'%')->get();
        $users = User::all();


        return view("admin.products.searchResult")->with('products',$products)->with('users',$users);
    }
    
}
