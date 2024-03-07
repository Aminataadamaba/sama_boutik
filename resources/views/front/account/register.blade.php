@extends('front.layouts.app')

@section('content')
 <!-- Breadcrumb Start -->
 <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('front.home') }}">Home</a>
                <a class="breadcrumb-item text-dark" href="{{ route('front.shop') }}">Shop</a>
                <span class="breadcrumb-item active">Register</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="section-10">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Register Now</h4>
                        <form action="/register" method="post" name="registrationForm" id="registrationForm">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Phone" id="phone" name="phone">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                <p></p>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                                <p></p>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block btn-lg">Register</button>
                        </form>
                        <div class="text-center mt-3 small">
                            <a href="#" class="forgot-link">Forgot Password?</a>
                        </div>
                        <div class="text-center mt-3 small">Already have an account? <a href="{{ route('account.login') }}">Login Now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')

<script type="text/javascript">
$("#registrationForm").submit(function(event) {
    event.preventDefault();

    $("button[type='submit']").prop('disabled',true);

    $.ajax({
    url: '{{ route("account.processRegister") }}',
    type: 'post',
    data: $(this).serializeArray(),
    dataType: 'json',
    success: function (response) {
        $("button[type='submit']").prop('disabled',false);

        var errors = response.errors;
      if (response.status == false) {
        if (errors.name) {
            $("#name").siblings('p').addClass('invalid-feedback').html(errors.name);
            $("#name").addClass('is-invalid');
        }else{
            $("#name").siblings('p').removeClass('invalid-feedback').html('');
            $("#name").removeClass('is-invalid');
        }

        if (errors.email) {
            $("#email").siblings('p').addClass('invalid-feedback').html(errors.email);
            $("#email").addClass('is-invalid');
        }else{
            $("#email").siblings('p').removeClass('invalid-feedback').html('');
            $("#email").removeClass('is-invalid');
        }

        if (errors.password) {
            $("#password").siblings('p').addClass('invalid-feedback').html(errors.password);
            $("#password").addClass('is-invalid');
        }else{
            $("#password").siblings('p').removeClass('invalid-feedback').html('');
            $("#password").removeClass('is-invalid');
        }

      }else{
        $("#name").siblings('p').removeClass('invalid-feedback').html('');
        $("#name").removeClass('is-invalid');

        $("#email").siblings('p').removeClass('invalid-feedback').html('');
        $("#email").removeClass('is-invalid');

        $("#password").siblings('p').removeClass('invalid-feedback').html('');
        $("#password").removeClass('is-invalid');

        window.location.href="{{ route('account.login') }}";

      }

    },
    error: function(jQXHR, exception) {
        console.log("Something went wrong");

    }
   });

});

</script>

@endsection
