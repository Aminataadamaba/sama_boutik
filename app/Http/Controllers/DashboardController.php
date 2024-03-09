<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
   public function index(){

    // nombre total de client

    $totalClients = User::count();
    $totalProduct = Product::count();

    return view('admin.dashboard',compact('totalClients','totalProduct'));

   }
}
