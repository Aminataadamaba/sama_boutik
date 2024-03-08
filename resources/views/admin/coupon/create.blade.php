@extends('admin.layouts.app')

@section('title', 'Create Coupons')

@section('content')
	<!-- Content Header (Page header) -->
	    <section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="d-flex align-items-center justify-content-between">
								<h1>Create Coupon Code</h1>
							 <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
	    </section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
					<form action="" method="post" id="categoryForm" name="categoryForm">
					  <div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="code">Code</label>
											<input type="text" name="code" id="code" class="form-control" placeholder="Coupon code">
                                            <p></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="max_uses">max Uses</label>
											<input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="max_uses">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="min_uses_ser">Min Uses User</label>
											<input type="text" min_uses="min_uses_user" id="min_uses_user" class="form-control" placeholder="Min Uses Userr">
                                            <p></p>
										</div>
									</div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="type">Type</label>
											<select name="type" id="type" class="form-control">
												<option value="percent">Percent</option>
												<option value="fixed">Fixed</option>
											</select>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="discount_amount">Discount Amount</label>
											<input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="discount_amount">Min Amount</label>
											<input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount">
                                            <p></p>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>
											<select name="status" id="status" class="form-control">
												<option value="1">1</option>
												<option value="0">0</option>
											</select>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="starts_at">Starts  At</label>
											<input type="text" name="starts_at" id="starts_at" class="form-control" placeholder="Starts At">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="expires_at">Expires At</label>
											<input type="textr" name="expires_at" id="expires_at" class="form-control" placeholder="Expire At">
                                            <p></p>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Create</button>
							<a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
					</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->


@endsection

@section('customJs')

<script>

$("#categoryForm").submit(function(event){
  event.preventDefault();
  var element = $(this);
  $("button[type=submit]").prop('disabled',true);
  $.ajax({
     url:'{{ route("categories.store") }}',
	 type: 'post',
	 data: element.serializeArray(),
	 dataType: 'json',
     success: function(response){
        $("button[type=submit]").prop('disabled', false);

        if (response["status"] == true) {

            window.location.href="{{ route('categories.index') }}";

            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");

        }else{
              var errors = response['errors'];

        if (errors['name']) {
            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
        }else{
            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }

        if (errors['slug']) {
            $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
        }else{
            $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }

        }

     }, error: function(jqXHR, exception){
        console.log("Something went wrong");
     }
  });
});

  $("#name").change(function(){
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

  Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url: "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg, image/png, image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        $("#image_id").val(response.image_id);
        //console.log(response);
    }
});


</script>

@endsection



