<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PageController extends Controller
{
   public function index(Request $request){
    $pages = Page::latest();

    if (!empty($request->get('keyword'))) {
        $pages = $pages->where('name','like','%'.$request->get('keyword').'%');
    }
    $pages = $pages->paginate(10);
    return view('admin.pages.list',compact('pages'));

   }

   public function create(Request $request){
    return view('admin.pages.create');
   }
   public function store(Request $request){
    $validator = Validator::make($request->all(), [
        'name'=> 'required',
        'slug'=> 'required|unique:pages',
        ]);

        if($validator->passes()){
            $page = new Page();
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'page added successfully';
            $request->session()->flash('success',$message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }


   }

   public function edit($id){

    $page = Page::find($id);
    if (empty($page)) {
        return redirect()->route('pages.index');
    }

    return view('admin.pages.edit', compact('page'));

   }
   public function update(Request $request, $id){

    $validator = Validator::make($request->all(), [
        'name'=> 'required',
        'slug'=> 'required',
        ]);
        $page = Page::find($id);
        if($validator->passes()){

            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->save();

            $message = 'page Update successfully';
            $request->session()->flash('success','page Update successfully');

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
   }

   public function destroy($id){
    $page = Page::find($id);
    if (empty($page)) {
    session()->flash('error','page not found');
     return response()->json([
        'status' => true,
        'message' => 'page dnot found delete'
     ]) ;

    }
    $page->delete();

    session()->flash('success','page deleted successfully');
    return response()->json([
        'status' => true,
        'message' => 'page deleted successfully'
    ]);

   }
}
