<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(){

        $totalClients = User::count();
       $totalProduct = Product::count();
       $totalCategory = Category::count();

       $totalMaleClients = User::where('genre', 'masculin')->count();
      $totalFemaleClients = User::where('genre', 'feminin')->count();
      $totalSexe = $totalFemaleClients + $totalMaleClients;


        return view('admin.dashboard',compact('totalClients','totalProduct','totalCategory','totalSexe','totalMaleClients','totalFemaleClients'));
        // $admin = Auth::guard('admin')->user();

        // echo 'Welcome'.$admin->name.' <a href="'.route('admin.logout').'">Logout</a> ';
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
