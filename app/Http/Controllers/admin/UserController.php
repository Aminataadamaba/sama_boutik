<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\PDF;
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

    public function generePdf()
    {
        $pdf = PDF::loadView('admin.users.client'); // Assurez-vous que 'client' est le nom de votre vue
        return $pdf->download('listeclient.pdf');
    }
}


