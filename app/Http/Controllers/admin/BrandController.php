<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands = Brand::latest('id');

      //  $brands = $brands->get();

        // return view('admin.brands.list',compact('categories'));

        if (!empty($request->get('keyword'))) {
            $brands = $brands->where('name','like','%'.$request->get('keyword').'%');
        }

        $brands = $brands->paginate(10);


        return view('admin.brands.list',compact('brands'));

    }

    public function create(Request $request){
        return view('admin.brands.create');
    }

    public function store(Request $request){

         $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'slug'=> 'required|unique:brands',
          ]);

          if($validator->passes()){


            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brands added successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function edit($id, Request $request){
        $brand = Brand::find($id);
        if(empty($brand)){
            $request->session()->flash('error','Record not found');
            return redirect()->route('brands.index');
        }

      $data['brand'] = $brand;

      return view('admin.brands.edit',$data);

    }

    public function update($id, Request $request){

        $brand = Brand::find($id);
        if (empty($brand)) {
            $request->session()->flash('error','brand Not found');
            return response()->json([
                'status'=> false,
                'notFound' => true,
                'message' => 'brand not found'
                ]);
        }
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'slug'=> 'required|unique:categories,slug,'.$brand->id.',id',
            ]);

            if($validator->passes()){

                $brand->name = $request->name;
                $brand->slug = $request->slug;
                $brand->status = $request->status;
                $brand->save();

                $request->session()->flash('success','brand updated successfully');

                return response()->json([
                    'status' => true,
                    'message' => 'brand updated successfully'
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

    }

    public function destroy($id, Request $request) {

        $brand = Brand::find($id);
        if(empty($brand)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,

            ]);

        }
        $brand->delete();

        $request->session()->flash('success','Brand deleted successfully');
        return response([
            'status' => true,
            'message' => ' Brand deleted successfully'
        ]);
    }

}
