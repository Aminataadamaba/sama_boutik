@extends('front.layouts.app')

@section('content')

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('front.home') }}">Home</a>
                <a class="breadcrumb-item text-dark" href="{{ route('front.shop') }}">Shop</a>
                <span class="breadcrumb-item active">Connexion</span>
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
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title text-center">Connectez-vous à votre compte</h4>
                        <form action="{{ route('account.authenticate') }}" method="post" name="loginForm" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password" name="password" >
                                @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-dark btn-block btn-lg">Connexion</button>
                        </form>
                        <div class="text-center mt-3 small">
                            <a href="#" class="forgot-link">Mot de passe oublié?</a>
                        </div>
                        <div class="text-center mt-3 small">Vous n'avez pas de compte? <a href="{{ route('account.register') }}">Inscrivez-vous</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
