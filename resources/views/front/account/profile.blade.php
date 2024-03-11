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
                <div class="card custom-card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <form action="" name="profileForm" id="profileForm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control" value="">
                                <p></p>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark btn-lg">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="card custom-card mt-5">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Addresse</h2>
                    </div>
                    <form action="" name="addressForm" id="addressForm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">First Name</label>
                                <input type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control" value="{{ (!empty($address)) ? $address->first_name : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control" value="{{ (!empty($address)) ? $address->last_name : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{ (!empty($address)) ? $address->email : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="text" name="mobile" id="mobile" placeholder="Enter Your mobile" class="form-control" value="{{ (!empty($address)) ? $address->mobile : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control">
                                    <option value="">Select a country</option>
                                    @if($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                    <option {{ (!empty($address) && $address->country_id == $country->id) ? 'selected' : ''}} value="{{ $country->id }}">{{ $country->name }}</option>

                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ (!empty($address)) ? $address->address : ''}}</textarea>
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apartment">Apartment</label>
                                <input type="text" name="apartment" id="apartment" placeholder="Enter Your apartment" class="form-control" value="{{ (!empty($address)) ? $address->apartment : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" placeholder="Enter Your city" class="form-control" value="{{ (!empty($address)) ? $address->city: ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="state">State</label>
                                <input type="text" name="state" id="state" placeholder="Enter Your state" class="form-control" value="" value="{{ (!empty($address)) ? $address->state : ''}}">
                                <p></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zip">Zip</label>
                                <input type="text" name="zip" id="zip" placeholder="Enter Your zip" class="form-control" value="{{ (!empty($address)) ? $address->zip : ''}}">
                                <p></p>
                            </div>


                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark btn-lg">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('customCss')
<style>
.custom-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
}

.custom-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.custom-card .form-group label {
    font-weight: bold;
    color: #333;
}

.custom-card .form-control {
    border: 1px solid #ced4da;
    border-radius: 5px;
}

.custom-card .btn-dark {
    background-color: #343a40;
    border-color: #343a40;
}

.custom-card .btn-dark:hover {
    background-color: #23272b;
    border-color: #23272b;
}
</style>
@endsection
@section('customJs')

<script>
    $("#profileForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response.status == true) {

                    $("#profileForm #name").removeClass('is-invalid').siblings('p').html(errors.name).removeClass('invalid-feedback');
                    $("#profileForm #email").removeClass('is-invalid').siblings('p').html(errors.email).removeClass('invalid-feedback');
                    $("#phone").removeClass('is-invalid').siblings('p').html(errors.phone).removeClass('invalid-feedback');
                    window.location.href = '{{ route("account.profile") }}'

                }else{
                    var errors = response.errors;
                    if (errors.name) {
                        $("#profileForm #name").addClass('is-invalid').siblings('p').html(errors.name).addClass('invalid-feedback');
                    }else{
                        $("#profileForm #name").removeClass('is-invalid').siblings('p').html(errors.name).removeClass('invalid-feedback');
                    }
                    if (errors.email) {
                        $("#profileForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    }else{
                        $("#profileForm #email").removeClass('is-invalid').siblings('p').html(errors.email).removeClass('invalid-feedback');
                    }
                    if (errors.phone) {
                        $("#profileForm #phone").addClass('is-invalid').siblings('p').html(errors.phone).addClass('invalid-feedback');
                    }else{
                        $("#profileForm #phone").removeClass('is-invalid').siblings('p').html(errors.phone).removeClass('invalid-feedback');
                    }
                }

            }
        });
    });
    $("#addressForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: '{{ route("account.updateAddress") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response.status == true) {

                    $("#first_name").removeClass('is-invalid').siblings('p').html(errors.first_name).removeClass('invalid-feedback');
                    $("#last_name").removeClass('is-invalid').siblings('p').html(errors.first_name).removeClass('invalid-feedback');
                    $("#addressForm #email").removeClass('is-invalid').siblings('p').html(errors.email).removeClass('invalid-feedback');
                    $("#mobile").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#country_id").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#address").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#apartment").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#city").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#zip").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    $("#state").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    window.location.href = '{{ route("account.profile") }}'

                }else{
                    var errors = response.errors;
                    if (errors.first_name) {
                        $("#first_name").addClass('is-invalid').siblings('p').html(errors.first_name).addClass('invalid-feedback');
                    }else{
                        $("#first_name").removeClass('is-invalid').siblings('p').html(errors.first_name).removeClass('invalid-feedback');
                    }
                    if (errors.last_name) {
                        $("#last_name").addClass('is-invalid').siblings('p').html(errors.last_name).addClass('invalid-feedback');
                    }else{
                        $("#last_name").removeClass('is-invalid').siblings('p').html(errors.last_name).removeClass('invalid-feedback');
                    }
                    if (errors.email) {
                        $("#addressForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    }else{
                        $("#addressForm #email").removeClass('is-invalid').siblings('p').html(errors.email).removeClass('invalid-feedback');
                    }
                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').siblings('p').html(errors.mobile).addClass('invalid-feedback');
                    }else{
                        $("#mobile").removeClass('is-invalid').siblings('p').html(errors.mobile).removeClass('invalid-feedback');
                    }
                    if (errors.country_id) {
                        $("#country_id").addClass('is-invalid').siblings('p').html(errors.country_id).addClass('invalid-feedback');
                    }else{
                        $("#country_id").removeClass('is-invalid').siblings('p').html(errors.country_id).removeClass('invalid-feedback');
                    }
                    if (errors.apartment) {
                        $("#apartment").addClass('is-invalid').siblings('p').html(errors.apartment).addClass('invalid-feedback');
                    }else{
                        $("#apartment").removeClass('is-invalid').siblings('p').html(errors.apartment).removeClass('invalid-feedback');
                    }
                    if (errors.state) {
                        $("#state").addClass('is-invalid').siblings('p').html(errors.state).addClass('invalid-feedback');
                    }else{
                        $("#state").removeClass('is-invalid').siblings('p').html(errors.state).removeClass('invalid-feedback');
                    }
                    if (errors.city) {
                        $("#city").addClass('is-invalid').siblings('p').html(errors.city).addClass('invalid-feedback');
                    }else{
                        $("#city").removeClass('is-invalid').siblings('p').html(errors.city).removeClass('invalid-feedback');
                    }
                    if (errors.zip) {
                        $("#zip").addClass('is-invalid').siblings('p').html(errors.zip).addClass('invalid-feedback');
                    }else{
                        $("#zip").removeClass('is-invalid').siblings('p').html(errors.zip).removeClass('invalid-feedback');
                    }

                }

            }
        });
    });

</script>

@endsection
