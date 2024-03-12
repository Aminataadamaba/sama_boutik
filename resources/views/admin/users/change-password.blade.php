@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
	<!-- Content Header (Page header) -->
	    <section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="d-flex align-items-center justify-content-between">
								<h1>Change Password</h1>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
	    </section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        @include('admin.message')
					<form action="" method="post" id="changePasswordForm" name="changePasswordForm">
					  <div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<label for="old_password">Old Password</label>
											<input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old password">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-12">
										<div class="mb-3">
											<label for="new_password">New Password</label>
											<input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password">
                                            <p></p>
										</div>
									</div>
                                    <div class="col-md-12">
										<div class="mb-3">
											<label for="confirm_password">Confirm Password</label>
											<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                            <p></p>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->


@endsection

@section('customJs')

<script>

$("#changePasswordForm").submit(function(e){
    e.preventDefault();
    $("#submit").prop('desabled',true);

    $.ajax({
        url: '{{ route("admin.processChangePassword") }}',
        type: 'post',
        data: $(this).serializeArray(),
        dataType: 'json',
        success: function(response){
            $("#submit").prop('desabled',false);
            if (response.status == true) {
                window.location.href = "{{ route('admin.showChangePasswordForm') }}"

            }else{
                var errors = response.errors;
                if (errors.old_password) {
                    $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.old_password)
                }else{
                    $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("")

                }
                if (errors.new_password) {
                    $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.new_password)
                }else{
                    $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("")

                }
                if (errors.confirm_password) {
                    $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password)
                }else{
                    $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("")

                }
            }
        }
    });
});




</script>

@endsection



