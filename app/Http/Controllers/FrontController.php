<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $products = Product::where('is_featured','Yes')->orderBy('id','DESC')->take(8)->where('status',1)->get();
        $data['featuredProducts'] = $products;
        $latestProducts = Product::orderBy('id','DESC')->where('status',1)->take(8)->get();
        $data['latestProducts'] = $latestProducts;

        $categories = Category::all(); // Récupérez toutes les catégories
        $data['categories'] = $categories; // Passez les catégories à la vue

        return view('front.home',$data);
    }
}


