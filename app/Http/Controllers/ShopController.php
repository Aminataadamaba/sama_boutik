<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];


       $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status',1)->get();
       $brands = Brand::orderBy('name', 'ASC')->where('status',1)->get();
    //    $products = Product::orderBy('title', 'DESC')->where('status',1)->get();
       $products = Product::where('status',1);
       // Appliquez des Filtres Ici
       if(!empty($categorySlug)){
        $category = Category::where('slug', $categorySlug)->first();
        $products = $products->where('category_id',$category->id);
        $categorySelected = $category->id;
       }
       if(!empty($categorySlug)){
        $subCategory =SubCategory::where('slug', $subCategorySlug)->first();
        $products = $products->where('sub_category_id',$subCategory->id);
        $subCategorySelected = $subCategory->id;
       }

       if (!empty($request->get('brand'))) {
        $brandsArray = explode(',', $request->get('brand'));
        $products = $products->whereIn('brand_id', $brandsArray);
    }

    if ($request->get('sort' != '')){
        if ($request->get('sort') == 'latest') {
            $products = $products->orderBy('id','DESC');
        }else if ($request->get('sort') == 'price-asc') {
            $products = $products->orderBy('price','ASC');
        }else {
            $products = $products->orderBy('price','DESC');
        }
    }else {
        $products = $products->orderBy('price','DESC');
    }
    $products = $products->paginate(6);
    //    $products = $products->orderBy('title', 'DESC');
    //    $products = $products->get();



       $data['categories'] = $categories;
       $data['brands'] = $brands;
       $data['products'] = $products;
       $data[' $categorySelected'] = $categorySelected;
       $data['subCategorySelected'] = $subCategorySelected;
       $data['brandsArray'] = $brandsArray;
       $data['sort'] = $request->get('sort');
        return view('front.shop', $data);
    }

    public function product($slug){
        $categories = Category::all(); // Récupérez toutes les catégories
        $data['categories'] = $categories;
        // $slug;
        $product = Product::where('slug', $slug)->with('product_images')->first();
        if ($product == null) {
           abort(404);
         }

         $relatedProducts = [];
         // Fetch remated product
         if($product->related_products != ''){
          $productArray = explode(',', $product->related_products);
          $relatedProducts = Product::whereIn('id', $productArray)->get();
         }
         $data['product'] = $product;
         $data['relatedProducts'] = $relatedProducts;
         return view('front.product',$data);
}
}
