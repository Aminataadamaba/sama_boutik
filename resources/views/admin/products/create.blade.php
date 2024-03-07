@extends('admin.layouts.app')

@section('content')

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h1>Create Product</h1>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" name="productForm" id="productForm" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="slug">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" ></textarea>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" ></textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="shipping_returns">Shipping And Returns</label>
                                        <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" ></textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-gallery">

                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a category</option>
                                    @if($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                       <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif

                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Select a sub category</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Select a brand</option>
                                    @if($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                       <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                    @endif

                                </select>
                                <p class="error"></p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Realated Products</h2>
                            <div class="mb-3">
                                <select multiple class="related-products w-100" name="related_products[]" id="related_products">

                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
         </div>
       </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection


@section('customJs')

<script>
     $('.related-products').select2({
    ajax: {
        url: '{{ route("products.getProducts") }}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
});

$("#title").change(function(){
    element = $(this);
    $("button[type=submit]").prop('disabled',true);
    $.ajax({
       url:'{{ route("getSlug") }}',
	   type: 'get',
	   data: {title: element.val()},
	   dataType: 'json',
       success: function(response){
        $("button[type=submit]").prop('disabled',false);
        if (response["status"] == true) {
            $("#slug").val(response["slug"]);

        }

     }

     });
   });
   $("#productForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled',true);

    // Vérifiez si un fichier a été sélectionné
    if ($("#image .dz-preview").length == 0) {
        // Affichez un message d'erreur ou effectuez une action appropriée
        alert('Please upload an image.');
        $("button[type=submit]").prop('disabled', false);
        return;
    }

    $.ajax({
        url: '{{ route("products.store") }}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response){
            $("button[type=submit]").prop('disabled',false);

            if (response["status"] == true) {
                window.location.href="{{ route('products.index') }}";

                // Réinitialisez les champs et les messages d'erreur
                $("#title, #slug, #description, #price, #compare_price, #sku, #barcode").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            } else {
                // Gérez les erreurs de validation comme vous le faites déjà dans votre script
                     var errors = response['errors'];

        if (errors['title']) {
            $("#title").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['title']);
        }else{
            $("#title").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }

        if (errors['slug']) {
            $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
        }else{
            $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['description']) {
            $("#description").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['description']);
        }else{
            $("#description").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['price']) {
            $("#price").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['price']);
        }else{
            $("#price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['compare_price']) {
            $("#compare_price").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['compare_price']);
        }else{
            $("#compare_price").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['sku']) {
            $("#sku").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['sku']);
        }else{
            $("#sku").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['barcode']) {
            $("#barcode").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['barcode']);
        }else{
            $("#barcode").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
            }
        },
        error: function(jqXHR, exception){
            console.log("Something went wrong");
        }
    });
});

  $("#category").change(function(){
    var category_id = $(this).val();
    $.ajax({
        url: '{{ route("product-subcategories.index") }}',
        type: 'get',
        data: {category_id: category_id},
        dataType: 'json',
        success: function(response){
            $("#sub_category").find("option").not(":first").remove();
            $.each(response["subCategories"], function(key, item){
                $("#sub_category").append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        },
        error: function(){
            console.log("Something went wrong");
        }
    });
});

Dropzone.autoDiscover = false;
const dropzone = new Dropzone("#image", {
    url: "{{ route('product-images.create') }}",
    maxFiles: 10,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg, image/png, image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        var html = '<div class="col-md-3" id="image-row-' + response.image_id + '">' +
            '<div class="card">' +
            '<input type="hidden" name="image_array[]" value="' + response.image_id + '">' +
            '<img src="' + response.ImagePath + '" class="card-img-top" alt="">' +
            '<div class="card-body">' +
            '<a href="javascript:void(0)" onclick="deleteImage(' + response.image_id + ')" class="btn btn-danger">Delete</a>' +
            '</div>' +
            '</div>' +
            '</div>';

        $("#product-gallery").append(html);
    },
    // complete: function (file) {
    //        this.removeFile(file);
    //
});

function deleteImage(id) {
    $("#image-row-" + id).remove();
}



</script>


@endsection

