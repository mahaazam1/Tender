<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{

        public function create(Request $request) {

        $category = new Category();
        $category->name = $request->name;

        if($request->image != ''){
            $image = time()+rand(1,1000000) . '.jpg';
            file_put_contents('storage/categories/'.$image,base64_decode($request->image));
            $category->image = $image;
        }


        //  // if($request->photo != ''){
        //     //choose a unique name for photo
        //     $photo = time().'.jpg';
        //     file_put_contents('storage/categories/'.$photo,base64_decode($request->photo));
        //     $category->image = $photo;
        // // }
        
        $category->save();

        return response()->json([
                'status' => true,
                'message' =>'created',
                'category' => $category
        ]);
    }

        public function categories(){
        $categories = Category::with('products')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
}
