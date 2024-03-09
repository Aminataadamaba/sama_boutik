<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::latest();
        if (!empty($request->get('keyword'))) {
            $users = $users->where('name','like','%'.$request->get('keyword').'%');
        }
        $users = $users->paginate(10);
        return view('admin.users.list',[
            'users'=> $users,
        ]);
    }
}
