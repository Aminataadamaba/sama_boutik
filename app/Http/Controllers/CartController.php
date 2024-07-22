<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\ShippingCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $cart = Session::get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->product_images->first()->image ?? null
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => $product->title . ' added to your cart successfully.',
            'cart' => $cart
        ]);
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return response()->json([
            'status' => true,
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function updateCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cart = Session::get('cart', []);

        if(isset($cart[$request->product_id])) {
            $product = Product::find($request->product_id);
            if ($product->track_qty == 'Yes' && $request->quantity > $product->qty) {
                return response()->json([
                    'status' => false,
                    'message' => 'Requested quantity not available in stock.'
                ], 400);
            }
            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ]);
    }

    public function deleteItem(Request $request)
    {
        $cart = Session::get('cart', []);

        if(isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart successfully',
            'cart' => $cart
        ]);
    }

    public function getCheckoutData()
    {
        $user = Auth::user();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();
        $countries = Country::orderBy('name', 'ASC')->get();
        $cart = Session::get('cart', []);

        $subTotal = 0;
        foreach($cart as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }

        $discount = 0;
        $shippingCharge = 0;

        if ($customerAddress) {
            $shippingInfo = ShippingCharge::where('country_id', $customerAddress->country_id)->first();
            if ($shippingInfo) {
                $totalQty = array_sum(array_column($cart, 'quantity'));
                $shippingCharge = $totalQty * $shippingInfo->amount;
            }
        }

        $grandTotal = $subTotal - $discount + $shippingCharge;

        return response()->json([
            'status' => true,
            'data' => [
                'customerAddress' => $customerAddress,
                'countries' => $countries,
                'cart' => $cart,
                'subTotal' => $subTotal,
                'discount' => $discount,
                'shippingCharge' => $shippingCharge,
                'grandTotal' => $grandTotal
            ]
        ]);
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:5',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        \DB::beginTransaction();

        try {
            // Save or update customer address
            CustomerAddress::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'country_id' => $request->country,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                ]
            );

            // Create order
            $order = new Order;
            $order->user_id = $user->id;
            $order->subtotal = array_sum(array_map(function($item) {
                return $item['quantity'] * $item['price'];
            }, $cart));
            $order->shipping = 0; // Calculate shipping
            $order->discount = 0; // Apply discount if any
            $order->grand_total = $order->subtotal + $order->shipping - $order->discount;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->notes;
            $order->country_id = $request->country;
            $order->save();

            // Save order items
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->name = $item['title'];
                $orderItem->qty = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->total = $item['quantity'] * $item['price'];
                $orderItem->save();

                // Update product stock
                if ($product->track_qty == 'Yes') {
                    $product->decrement('qty', $item['quantity']);
                }
            }

            // Clear cart
            Session::forget('cart');

            \DB::commit();

            // Send order email
            // orderEmail($order->id, 'customer');

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'orderId' => $order->id
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing your order'
            ], 500);
        }
    }

    public function applyDiscount(Request $request)
    {
        $code = DiscountCoupon::where('code', $request->code)->first();

        if (!$code) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid discount coupon'
            ], 404);
        }

        $now = Carbon::now();

        if ($code->starts_at && $now->lt(Carbon::parse($code->starts_at))) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is not yet active'
            ], 400);
        }

        if ($code->expires_at && $now->gt(Carbon::parse($code->expires_at))) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon has expired'
            ], 400);
        }

        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();
            if ($couponUsed >= $code->max_uses) {
                return response()->json([
                    'status' => false,
                    'message' => 'This coupon has reached its usage limit'
                ], 400);
            }
        }

        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::id()])->count();
            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have already used this coupon the maximum number of times'
                ], 400);
            }
        }

        $cart = Session::get('cart', []);
        $subTotal = array_sum(array_map(function($item) {
            return $item['quantity'] * $item['price'];
        }, $cart));

        if ($code->min_amount > 0 && $subTotal < $code->min_amount) {
            return response()->json([
                'status' => false,
                'message' => 'Your order total must be at least $' . $code->min_amount . ' to use this coupon'
            ], 400);
        }

        $discount = $code->type == 'percent'
            ? ($code->discount_amount / 100) * $subTotal
            : $code->discount_amount;

        Session::put('applied_coupon', $code->id);

        return response()->json([
            'status' => true,
            'message' => 'Discount applied successfully',
            'discount' => $discount,
            'grandTotal' => $subTotal - $discount
        ]);
    }

    public function removeCoupon()
    {
        Session::forget('applied_coupon');

        $cart = Session::get('cart', []);
        $subTotal = array_sum(array_map(function($item) {
            return $item['quantity'] * $item['price'];
        }, $cart));

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully',
            'grandTotal' => $subTotal
        ]);
    }
}
