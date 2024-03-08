<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function index(){

    }

    public function create(){

    }
    public function store(Request $request){
        return view('admin.coupon.create');
    }



    public function edit($id){

    }
    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
