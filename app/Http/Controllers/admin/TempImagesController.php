<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;

class TempImagesController extends Controller
{
    public function create(Request $request){

        $image = $request->image;
        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp', $newName);

          //  generate thumbnail
            // $sourcePath = public_path().'/temp/'.$newName;
            // $destPath = public_path().'/temp/thumb/'.$newName;
            // $img = Image::make($sourcePath);
            // $img->fit(300, 300);
            // $img->save($destPath);

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'ImagePath' => asset('/uploads/product/large/'.$newName),
                'message' => 'Image uploaded successfully'
            ]);
        }
    }
}
