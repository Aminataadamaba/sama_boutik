<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;



class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories = $categories->paginate(10);


        return view('admin.category.list',compact('categories'));

    }


    public function create(){

        return view('admin.category.create');
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'slug'=> 'required|unique:categories',
            ]);

            if($validator->passes()){
                $category = new Category();
                $category->name = $request->name;
                $category->slug = $request->slug;
                $category->status = $request->status;
                $category->image = $request->image;
                $category->showHome = $request->showHome;
                $category->save();

                // save image here
                if (!empty($request->image_id)) {
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.',$tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $category->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);

                    $category->image = $newImageName;
                    $category->save();
                }
                $request->session()->flash('success','Category added successfully');

                return response()->json([
                    'status' => true,
                    'message' => 'Category added successfully'
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }


    }

    public function edit($categoriesId, Request $request){
        $category = Category::find($categoriesId);
        if (empty($category)) {
            return redirect()->route('categories.index');

        }

        return view('admin.category.edit', compact('category'));

    }

    public function update($categoriesId, Request $request){

        $category = Category::find($categoriesId);
        if (empty($category)) {
            $request->session()->flash('error','Category Not found');
            return response()->json([
                'status'=> false,
                'notFound' => true,
                'message' => 'Category not found'
                ]);
        }
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'slug'=> 'required|unique:categories,slug,'.$category->id.',id',
            ]);

            if($validator->passes()){



                $category->name = $request->name;
                $category->slug = $request->slug;
                $category->status = $request->status;
                $category->showHome = $request->showHome;
                $category->save();

                $oldImage = $category->Image;

                // save image here

                if (!empty($request->image_id)) {
                    $tempImage = TempImage::find($request->image_id);

                    $extArray = explode('.',$tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $category->id.'-'.time().'.'.$ext;
                    $newImageName = $category->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);



                    $category->image = $newImageName;
                    $category->save();

                    // Delete old Image here
                    File::delete(public_path().'/uploads/category/'.$oldImage);

                }

                $request->session()->flash('success','Category updated successfully');

                return response()->json([
                    'status' => true,
                    'message' => 'Category updated successfully'
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

    }

    public function destroy($categoriesId, Request $request){
            $category = Category::find($categoriesId);
            if (empty($category)) {
                $request-session()->flash('error','Category not found');
             //   return redirect()->route('categories.index');
             return response()->json([
                'status' => true,
                'message' => 'Category dnot found delete'
             ]) ;

            }
            File::delete(public_path().'/uploads/category/'.$category->image);
            $category->delete();

            $request->session()->flash('success','Category deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully'
            ]);
    }
}
