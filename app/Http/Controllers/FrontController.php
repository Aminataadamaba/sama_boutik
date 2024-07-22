<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', 'Yes')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $latestProducts = Product::where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $categories = Category::all();

        return response()->json([
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
            'categories' => $categories
        ]);
    }

    public function addToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $product = Product::find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->id
            ],
            [
                'user_id' => Auth::id(),
                'product_id' => $request->id
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Product added to your wishlist'
        ]);
    }

    public function getPage($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page == null) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        $categories = Category::all();

        return response()->json([
            'page' => $page,
            'categories' => $categories
        ]);
    }
}
