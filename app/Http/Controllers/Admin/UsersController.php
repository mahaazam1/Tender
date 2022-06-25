<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Buyer;
use App\Product;
use App\Category;


class UsersController extends Controller
{
    public function getSellers(Request $request){
        $paginate = 8;
        $sellers= User::select('*')->paginate($paginate);
       
        return view('admin.dashboard.dashboard')
        ->with('sellers', $sellers)->with('buyers',count(Buyer::all()))
        ->with('products',count(Product::all()))->with('categories',count(Category::all()));
    }
}
