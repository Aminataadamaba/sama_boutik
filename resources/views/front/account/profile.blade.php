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
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card custom-card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-dark btn-lg">Update</button>
                            </div>
                        </div>
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
