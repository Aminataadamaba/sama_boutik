<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;

// API Routes
Route::prefix('api')->group(function () {
    // Home
    Route::get('/', [FrontController::class, 'index'])->name('api.home');

    // Client
    Route::get('/client', [UserController::class, 'generePdf'])->name('api.client');

    // Shop
    Route::get('/shop', [ShopController::class, 'index'])->name('api.shop.index');
    Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('api.shop.category');
    Route::get('/products/{slug}', [ShopController::class, 'product'])->name('api.product.show');
});

Route::prefix('api')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::put('/cart', [CartController::class, 'updateCart']);
    Route::delete('/cart/{productId}', [CartController::class, 'deleteItem']);
    Route::get('/checkout', [CartController::class, 'getCheckoutData']);
    Route::post('/checkout', [CartController::class, 'processCheckout']);
    Route::get('/order/{orderId}', [CartController::class, 'getOrderDetails']);
    Route::post('/order-summary', [CartController::class, 'getOrderSummary']);
    Route::post('/discount', [CartController::class, 'applyDiscount']);
    Route::delete('/discount', [CartController::class, 'removeCoupon']);
    Route::post('/wishlist', [FrontController::class, 'addToWishlist']);
    Route::get('/page/{slug}', [FrontController::class, 'getPage']);

    // Auth routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'getProfile']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/address', [AuthController::class, 'updateAddress']);
        Route::put('/password', [AuthController::class, 'changePassword']);
        Route::get('/orders', [AuthController::class, 'getOrders']);
        Route::get('/wishlist', [AuthController::class, 'getWishlist']);
        Route::delete('/wishlist/{productId}', [AuthController::class, 'removeFromWishlist']);
        Route::get('/order/{orderId}', [AuthController::class, 'getOrderDetail']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
