@extends('front.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('account.login') }}">My Account</a>
                <span class="breadcrumb-item active">Settings</span>
            </nav>
        </div>
    </div>
</div>

<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @include('front.account.common.message')
            </div>
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                    </div>
                    <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="old_password" class="text-dark">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password" class="text-dark">New Password</label>
                                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="text-dark">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="form-group">
                                        <button id="submit" type="submit" class="btn btn-dark">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
$("#changePasswordForm").submit(function(e){
    e.preventDefault();
    $("#submit").prop('desabled',true);

    $.ajax({
        url: '{{ route("account.processChangePassword") }}',
        type: 'post',
        data: $(this).serializeArray(),
        dataType: 'json',
        success: function(response){
            $("#submit").prop('desabled',false);
            if (response.status == true) {
                window.location.href = "{{ route('account.changePassword') }}"

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
