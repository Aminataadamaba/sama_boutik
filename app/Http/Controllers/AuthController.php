<?php

namespace App\Http\Controllers;
use App\Models\Category;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
   public function login(Request $request){
    $categories = Category::all(); // Récupérez toutes les catégories
    $data['categories'] = $categories; // Passez les catégories à la vue
    return view('front.account.login',$data);


   }
   public function register(){
    $categories = Category::all(); // Récupérez toutes les catégories
    $data['categories'] = $categories; // Passez les catégories à la vue
    return view('front.account.register', $data);
   }

   public function processRegister(Request $request){

    $validator = Validator::make($request->all(), [
        'name'=> 'required|min:3',
        'email'=> 'required|email|unique:users',
        'password'=> 'required|min:5|confirmed'
    ]);

    if($validator->passes()){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success','You have been registered sucessfully.');

        return response()->json([
            'status' =>true,
        ]);

    }else {
        return response()->json([
            'status' =>false,
            'errors'=> $validator->errors()

        ]);
    }

   }

   public function authenticate(Request $request){
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password'=> 'required',
        ]);

        if($validator->passes()){

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');
            }else {
                return redirect()->route('account.login')->withInput($request->only('email'))->with('error','Either email/password is incorrect.');
            }

        }else{
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
   }

   public function profile(Request $request){
    $categories = Category::all(); // Récupérez toutes les catégories
    $data['categories'] = $categories; // Passez les catégories à la vue
    return view('front.account.profile',$data);

   }

   public function logout(Request $request){
    Auth::logout();
    return redirect()->route('account.login')->with('success','Your successfully logget out!');

   }

   public function orders(Request $request){
    $data = [];
    $user = Auth::user();

    $orders = Order::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
    $categories = Category::all(); // Récupérez toutes les catégories
    $data['categories'] = $categories; // Passez les catégories à la vue
    $data['orders'] = $orders;
    return view('front.account.order',$data);
   }

   public function orderDetail($id){
    $data = [];
    $user = Auth::user();
    $order = Order::where('user_id', $user->id)->where('id',$id)->first();


    $orderItems =  OrderItem::where('order_id', $id)->get();
    $categories = Category::all();
    $data['categories'] = $categories;
    $data['order'] = $order;
    $data['orderItems'] = $orderItems;
    $orderItemsCount = OrderItem::where('order_id', $id)->count();
    $data['orderItemsCount'] = $orderItemsCount;
    return view('front.account.order-detail',$data);
   }

   public function wishlist(){
    $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
    $data = [];
    $categories = Category::all();
    $data['categories'] = $categories;
    $data['wishlists'] = $wishlists;
    return view('front.account.wishlist',$data);
   }
   public function removeProductFormWishList(Request $request){
    $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id',$request->id)->first();

    if($wishlist == null){
        session()->flash('error','Product already removed.');
        return  response()->json([
            'status' =>true,
        ]);
    }else{
        Wishlist::where('user_id', Auth::user()->id)->where('product_id',$request->id)->delete();
        session()->flash('success','Product removed successfully.');
        return  response()->json([
            'status' =>true,

        ]);
    }

   }
}
