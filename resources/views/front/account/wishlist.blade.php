@extends('front.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('account.login') }}">My Account</a>
                <span class="breadcrumb-item active">My Wishlist</span>
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
                        <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                    </div>
                    <div class="card-body p-4">
                        @if($wishlists->isNotEmpty())
                        @foreach ($wishlists as $wishlist)
                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route("front.product",$wishlist->product->slug) }}" style="width: 10rem;">
                                @php
                                   $productImage = getProductImage($wishlist->product_id);
                                @endphp
                                @if (!empty($productImage))
                                <img class="img-fluid w-100" src="{{ asset('storage/uploads/product/large/'.$productImage->image) }}"   />
                                @else
                                 <img  src="{{ asset('front-assets/img/product-1.jpg') }}" alt="" class="img-fluid w-100">
                                @endif</a>
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2"><a href="{{ route("front.product",$wishlist->product->slug) }}">{{ $wishlist->product->title }}</a></h3>
                                    <h5>{{ $wishlist->product->price }} Fcf</h5>
                                    @if ($wishlist->product->compare_price > 0 )
                                    <h6 class="text-muted ml-2"><del>{{ $wishlist->product->compare_price }} Fcf</del></h6>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <button onclick="removeProduct({{ $wishlist->product_id }});" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div>
                            <h3 class="h5">Votre liste de souhait est vide!!</h3>
                        </div>
                        @endif

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
    function removeProduct(id) {
        $.ajax({
            url: '{{ route("account.removeProductFormWishList") }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    window.location.href= "{{ route('account.wishlist') }}";
                }
            }
       });
    }
</script>

@endsection
