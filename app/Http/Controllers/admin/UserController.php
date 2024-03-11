<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;


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
    public function create(){
        return view('admin.users.create');
    }
    public function store(Request $request){
       $validator = Validator::make($request->all(), [
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
        'password'=> 'required|min:5',
        'genre' => 'required',
        'phone' => 'required',
       ]);
       if ($validator->passes()) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->save();

        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.',$tempImage->name);
            $ext = last($extArray);

            $newImageName = $user->id.'.'.$ext;
            $sPath = public_path().'/temp/'.$tempImage->name;
            $dPath = public_path().'/uploads/user/'.$newImageName;
            File::copy($sPath,$dPath);

            $user->image = $newImageName;
            $user->save();
        }



        $message = 'User added successfully';

        session()->flash('success',$message);
        return response()->json([
            'status' =>true,
            'message' => $message
        ]);

       }else{
        return response()->json([
            'status' =>false,
            'errors' =>$validator->errors()
        ]);

       }
    }
    public function edit($id,Request $request){
        $user = User::find($id);
        if($user == null){
            $message = 'Record not found';
            session()->flash('error',$message);
            return redirect()->route('users.index');
        }

      return view('admin.users.edit',[
        'user'=> $user,
      ]);
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        if($user == null){
            $message = 'User not found';
            session()->flash('error',$message);

            return response()->json([
                'status' =>true,
                'message' => $message
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email,'.$id.',id',
            'phone' => 'required',
            'genre' => 'required'
           ]);
           if ($validator->passes()) {

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }

            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->genre = $request->genre;
            $user->save();
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $user->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/user/'.$newImageName;
                File::copy($sPath,$dPath);

                $user->image = $newImageName;
                $user->save();
            }

            $message = 'User Update successfully';

            session()->flash('success',$message);
            return response()->json([
                'status' =>true,
                'message' => $message
            ]);

           }else{
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);

           }
    }
    public function destroy($id){
        $user = User::find($id);
        if($user == null){
            $message = 'User not found';
            session()->flash('error',$message);

            return response()->json([
                'status' =>true,
                'message' => $message
            ]);
        }

        $user->delete();
        $message = 'User deleted successfully';
        session()->flash('success',$message);

        return response()->json([
            'status' =>true,
            'message' => $message
        ]);
    }

    public function generePdf()
    {
        $pdf = PDF::loadView('admin.users.client'); // Assurez-vous que 'client' est le nom de votre vue
        return $pdf->download('listeclient.pdf');
    }
}


