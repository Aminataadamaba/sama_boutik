@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
	<!-- Content Header (Page header) -->
	    <section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="d-flex align-items-center justify-content-between">
								<h1>Edit User</h1>
							 <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
	    </section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
					<form action="" method="post" id="userForm" name="userForm" enctype="multipart/form-data">
					  <div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                                            <p></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Email</label>
											<input type="email"   name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="password">Password</label>
											<input type="password" name="password" id="password" class="form-control" placeholder="Password" >
                                            <span>To change password you have to enter a value, otherwise leave blank.</span>
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Phone</label>
											<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{ $user->phone }}">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-6">
                                        <div class="md-3">
                                            <input type="hidden" id="image_id" name="image_id" >
                                            <label for="image">Image</label>
                                          <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">
                                                    Déposer le fichier ici ou cliquez pour le télécharger
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="genre">Genre</label>
											<select name="genre" id="genre" class="form-control">
                                                <option value="">Select Sexe</option>
												<option {{ ($user->genre == 'masculin') ? 'selected' : '' }} value="masculin">Masculin</option>
												<option {{ ($user->genre == 'feminin') ? 'selected' : '' }} value="feminin">Feminin</option>
                                                <p></p>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>
											<select name="status" id="status" class="form-control">
												<option {{ ($user->status == 1) ? 'selected' : '' }} value="1">Active</option>
												<option {{ ($user->status == 0) ? 'selected' : '' }}  value="0">Block</option>
                                                <p></p>
											</select>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
					</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->


@endsection

@section('customJs')

<script>

$("#userForm").submit(function(event){
  event.preventDefault();
  var element = $(this);
  $("button[type=submit]").prop('disabled',true);
  $.ajax({
     url:'{{ route("users.update",$user->id) }}',
	 type: 'put',
	 data: element.serializeArray(),
	 dataType: 'json',
     success: function(response){
        $("button[type=submit]").prop('disabled', false);

        if (response["status"] == true) {

            window.location.href="{{ route('users.index') }}";

            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
            $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");

        }else{
              var errors = response['errors'];

        if (errors['name']) {
            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
        }else{
            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }

        if (errors['email']) {
            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
        }else{
            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['password']) {
            $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
        }else{
            $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        if (errors['phone']) {
            $("#phone").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['phone']);
        }else{
            $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }

        }

     }, error: function(jqXHR, exception){
        console.log("Something went wrong");
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



