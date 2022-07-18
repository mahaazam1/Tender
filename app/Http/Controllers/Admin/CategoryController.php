<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\Store;
use App;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        // dd($categories);
        // App::setLocale('es');
        return view('admin.categories.index')->with('categories',$categories);
    }


    public function create(){
        App::setLocale('ar');
        return view('admin.categories.create');
    }

    public function store (Request $request) {

        $image = $request->file('image');
        $path = 'public/images/';
        $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
        Storage::disk('local')->put($path.$nameImage , file_get_contents($image));

        $name = $request['name'];

        $category = new Category();
        $category->name = $name;
        $category->image = 'images/'.$nameImage;
        $result = $category->save();
    
        return redirect()->back()->with('status',$result);
    }

    public function destroy($id){
        $category = Category::where("id",$id)->delete();
        //$store = Store::where("category_id",$id)->delete();

         // dd($category);
        return redirect()->back();
    }

    public function edit($id){
        $category = Category::where("id",$id)->first();
        // dd($category);
        return view('admin.categories.edit')->with("category",$category);
    }

    public function update(Request $request, $id){
        $name = $request->name;
        $category = Category::find($request->id);
        $category->name = $name;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = 'public/images/';
            $nameImage = time()+rand(1,1000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path.$nameImage , file_get_contents($image));
            $category->image = 'images/'.$nameImage;
        }
        $category->update();
            return redirect('category');
            // return redirect()->back();
    }
}

