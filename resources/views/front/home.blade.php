@extends('front.layouts.app')

@section('content')



<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item position-relative active" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="{{ asset('front-assets/img/carousel-1.jpg') }}" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Men Fashion</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item position-relative" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="{{ asset('front-assets/img/carousel-2.jpg') }}" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Women Fashion</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item position-relative" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="{{ asset('front-assets/img/carousel-3.jpg') }}" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Kids Fashion</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="{{ asset('front-assets/img/offer-1.jpg') }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="{{ asset('front-assets/img/offer-2.jpg') }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
    <div class="row px-xl-5 pb-3">
        @if (getCategories()->isNotEmpty())
        @foreach (getCategories() as $category)
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                        @if ($category->image != "")
                        <img class="img-fluid" src="{{ asset('uploads/category/'.$category->image) }}" alt="">
                         @endif
                    </div>
                    <div class="flex-fill pl-3">
                        <h6>{{ $category->name }}</h6>
                        {{-- <small class="text-body">100 Products</small> --}}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</div>
<!-- Categories End -->


<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
    <div class="row px-xl-5">
        @if ($featuredProducts->isNotEmpty())
        @foreach ($featuredProducts as $product)
              @php
                   $productImage = $product->product_images->first();
              @endphp
          <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <div class="product-item bg-light mb-4">
                <div class="product-img position-relative overflow-hidden">
                    {{-- <a href="{{ route("front.product",$product->slug) }}" class="product-imm"> --}}
                    @if (!empty($productImage->image))
                    <img class="img-fluid w-100" src="{{ asset('storage/uploads/product/large/'.$productImage->image) }}"   />
                    @else
                     <img  src="{{ asset('front-assets/img/product-1.jpg') }}" alt="" class="img-fluid w-100">
                    @endif
                  {{-- </a> --}}
                    <div class="product-action">
                        {{-- @if ()

                        @endif --}}
                        <a class="btn btn-outline-dark btn-square" href="javascript:void();" onclick="addToCart({{ $product->id }});"><i class="fa fa-shopping-cart"></i></a>
                        <a onclick="addToWishlist({{ $product->id }})"  class="btn btn-outline-dark btn-square" href="javascript:void(0);"><i class="far fa-heart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                        <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href="{{ route("front.product",$product->slug) }}">{{ $product->title }}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>{{ $product->price }} Fcf</h5>
                        @if ($product->compare_price > 0 )
                        <h6 class="text-muted ml-2"><del>{{ $product->compare_price }} Fcf</del></h6>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small>(99)</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>
</div>
<!-- Products End -->


<!-- Offer Start -->
<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ asset('front-assets/img/offer-1.jpg') }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ asset('front-assets/img/offer-2.jpg') }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Produits récents</span></h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 px-xl-5"> <!-- Utilisation de row-cols-* pour ajuster automatiquement le nombre de colonnes en fonction de la taille de l'écran -->
        @if ($latestProducts->isNotEmpty())
        @foreach ($latestProducts as $product)
        @php
        $productImage = $product->product_images->first();
        @endphp
        <div class="col mb-4"> <!-- Utilisation de la classe col pour ajuster automatiquement la taille des colonnes -->
            <div class="product-item bg-light"> <!-- Ajout de la classe bg-light pour un arrière-plan uniforme -->
                <div class="product-img position-relative overflow-hidden">
                    <div class="img-container">
                        <a href="{{ route("front.product",$product->slug) }}" class="pruduct-img">
                        @if (!empty($productImage->image))
                        <img class="img-fluid" src="{{ asset('storage/uploads/product/large/'.$productImage->image) }}" alt="{{ $product->title }}" />
                        @else
                        <img class="img-fluid" src="{{ asset('front-assets/img/product-5.jpg') }}" alt="{{ $product->title }}" />
                        @endif
                    </a>
                    </div>

                    <div class="product-action">
                        <a class="btn btn-outline-dark btn-square" href="javascript:void();" onclick="addToCart({{ $product->id }});"><i class="fa fa-shopping-cart"></i></a>
                        <a onclick="addToWishlist({{ $product->id }})"  class="btn btn-outline-dark btn-square" href="javascript:void(0);"><i class="far fa-heart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href="{{ route("front.product",$product->slug) }}">{{ $product->title }}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>{{ $product->price }} Fcf</h5>
                        @if ($product->compare_price > 0 )
                        <h6 class="text-muted ml-2"><del>{{ $product->compare_price }} Fcf</del></h6>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small class="fa fa-star text-primary mr-1"></small>
                        <small>(99)</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>


<!-- Products End -->


<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-1.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-2.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-3.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-4.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-5.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-6.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-7.jpg') }}" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="{{ asset('front-assets/img/vendor-8.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->


@endsection




