<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::latest('id')->with('product_images');


        if (!empty($request->get('keyword'))) {
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
       }
        $products = $products->paginate();


        $data['products'] = $products;
        return view('admin.products.list',$data);
    }

    public function create(){
        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;

      return view("admin.products.create", $data);
    }

    public function store(Request $request){

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category'=> 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour l'image principale

        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

         $validator = Validator::make($request->all(), $rules);

         if ($validator->passes()) {
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) :'';
            $product->save();

            // Gérer l'image principale
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $product->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/uploads/product/large'), $imageName);

            // Mettre à jour le nom de l'image principale dans la base de données
            $product->image = $imageName;
            $product->save();
        }

        // Gérer les images supplémentaires
        if ($request->hasFile('image_array')) {
            foreach ($request->file('image_array') as $image) {
                if ($image->isValid()) {
                    $imageName = $product->id . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('storage/uploads/product/large'), $imageName);

                    // Créer une nouvelle instance de ProductImage et enregistrer l'image
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id; // Assurez-vous de définir l'ID du produit
                    $productImage->image = $imageName;
                    $productImage->save();
                }
            }
        }

        // Message de succès
        $request->session()->flash('success', 'Produit ajouté avec succès');

        return response([
            'status' => true,
            'message' => 'Produit ajouté avec succès'
        ]);
    } else {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
    }

    public function edit($id, Request $request){

       $product = Product::find($id);

       if (empty($product)) {

           //   $request->session()->flash('error','Product Not Found');
        return redirect()->route('products.index')->with('error','Product Not Found');
       }

       // Fetch Product Image

        $productImages = ProductImage::where('product_id',$product->id)->get();

       $subCategories = SubCategory::where('category_id', $product->category_id)->get();
       $relatedProducts = [];
       // Fetch remated product
       if($product->related_products != ''){
        $productArray = explode(',', $product->related_products);
        $relatedProducts = Product::whereIn('id', $productArray)->with('product_images')->get();
       }

        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $data['productImages'] = $productImages;
        $data['relatedProducts'] = $relatedProducts;

      return view('admin.products.edit', $data);

    }

    public function update($id, Request $request){

        $product = Product::find($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No',
            'category'=> 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

         $validator = Validator::make($request->all(), $rules);

         if ($validator->passes()) {

            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->related_products = (!empty($request->related_products)) ? implode(',', $request->related_products) :'';
            $product->save();
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne photo si nécessaire
                // Assurez-vous d'importer la classe File en haut du fichier
                if (!empty($product->image)) {
                    File::delete(public_path('storage/uploads/product/large/' . $product->image));
                }

                // Télécharger et enregistrer la nouvelle photo
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'storage/uploads/product/large/', $imageName);

                // Mettre à jour le nom de la photo dans la base de données
                $product->image = $imageName;
            }

            // Sauvegarde du produit
            $product->save();


            $request->session()->flash('success','product update successfully');

            return response([
                'status' => true,
                'message' => 'product update successfully'
            ]);

         }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
         }

    }


    public function destroy($id, Request $request){
        $product = Product::find($id);
        if (empty($product)) {
            $request-session()->flash('error','Product not found');
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        // Supprimer l'image associée si elle existe
        if (!empty($product->image)) {
            Storage::delete('public/uploads/product/large/' . $product->image);
        }

        // Supprimer le produit de la base de données
        $product->delete();

        $request->session()->flash('success','Product deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }


public function getProducts(Request $request){

    $tempProduct = [];
    if ($request->term != "") {
        $products = Product::where('title','like','%'.$request->term.'%')->get();
        if ($products != null) {
            foreach ($products as $product) {
                $tempProduct[] = array('id' => $product->id, 'text' => $product->title);
            }
       }
    }
    return response()->json([
        'tags' => $tempProduct,
        'status'=> true,
    ]);
}
// public function export()
// {
//     // Récupérer tous les produits de la base de données
//     $products = Product::all();

//     // Exporter les produits vers un fichier Excel
//     return Excel::download(new ($products), 'products.xlsx');
// }

}
