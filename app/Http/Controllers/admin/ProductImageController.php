<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
// use Intervention\Image\File;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Image;

//use Faker\Provider\Image;
// use Intervention\Image\Image;

class ProductImageController extends Controller
{
    public function create(Request $request)
    {


        // Validation de l'image
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Taille maximale de 2 Mo
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid image file.',
            ]);
        }

        // Traitement de l'image
        $image = $request->file('image');

        // Génération d'un nouveau nom pour l'image
        $newName = time() . '.' . $image->getClientOriginalExtension();

        // Déplacement de l'image vers le répertoire de stockage temporaire
        $image->move(public_path('storage/uploads/product/large/'), $newName);

        // Enregistrement de l'image temporaire dans la base de données
        $tempImage = new TempImage();
        $tempImage->name = $newName;
        $tempImage->save();



        // Réponse JSON avec les informations sur l'image téléchargée
        return response()->json([
            'status' => true,
            'image_id' => $tempImage->id,
            'ImagePath' => asset('storage/uploads/product/large/' . $newName),
            'message' => 'Image uploaded successfully',
        ]);



    }
    public function update(Request $request){

        $image = $request->image;

        // Vérifiez si une image a été téléchargée
        if ($request->hasFile('image')) {
            $ext = $image->getClientOriginalExtension();
            $imageName = $request->product_id . '-' . time() . '.' . $ext;

            // Déplacez l'image téléchargée vers le répertoire de stockage
            $image->move(public_path('storage/uploads/product/large/'), $imageName);

            // Créez une nouvelle instance de ProductImage
            $productImage = new ProductImage();
            $productImage->product_id = $request->product_id;
            $productImage->image = $imageName;
            $productImage->save();

            return response()->json([
                'status' => true,
                'image_id' => $productImage->id,
                'ImagePath' => asset('storage/uploads/product/large/'.$productImage->image),
                'message' => 'Image saved successfully'
            ]);
        }

        // Si aucune image n'a été téléchargée, retournez une réponse d'erreur
        return response()->json([
            'status' => false,
            'message' => 'No image uploaded'
        ]);
    }

    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);
        if (empty($productImage)) {
            return response()->json([
                'status' => false,
                'message' => 'Image Delete successfully'
            ]);
        }
        // Dekete image from

        File::delete(public_path('storage/uploads/product/large/'.$productImage->image));
        File::delete(public_path('storage/uploads/product/small/'.$productImage->image));

        $productImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image Delete successfully'
        ]);
    }
}
