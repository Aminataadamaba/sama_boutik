<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];

        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status', 1);

        // Appliquez des Filtres Ici
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }

        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), 1000000]);
            } else {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max')), 10000000]);
            }
        }

        if (!empty($request->get('search'))) {
            $products = $products->where('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } else if ($request->get('sort') == 'price-asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->orderBy('price', 'DESC');
        }

        $products = $products->paginate(6);

        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'categorySelected' => $categorySelected,
            'subCategorySelected' => $subCategorySelected,
            'brandsArray' => $brandsArray,
            'sort' => $request->get('sort')
        ];

        return response()->json($data);
    }

    public function product($slug)
    {
        $categories = Category::all();
        $product = Product::where('slug', $slug)->with('product_images')->first();

        if ($product == null) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArray)->where('status', 1)->get();
        }

        $data = [
            'categories' => $categories,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];

        return response()->json($data);
    }
}
