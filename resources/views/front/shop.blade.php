@extends('front.layouts.app')

@section('content')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{route('front.home')}}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{route('front.shop')}}">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                <div class="bg-light p-4 mb-30">

                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>

                        </div>
                        @if($products->isNotEmpty())
                        @foreach ($products as $product)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="product-{{ $product->id }}" value="{{ $product->id }}" name="product">
                            <label class="custom-control-label" for="price-1">${{ $product->price }} - ${{ $product->compare_price }}</label>
                        </div>
                        @endforeach
                        @endif
                    </form>

                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtre by Brand</span></h5>
                <div class="bg-light p-4 mb-30">

                        @if($brands->isNotEmpty())
                        @foreach ($brands as $brand)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input {{ (in_array($brand->id, $brandsArray)) ? 'checked' : '' }} type="checkbox" class="custom-control-input brand-label" id="brand-{{ $brand->id }}" value="{{ $brand->id }}" name="brand[]">
                            <label class="custom-control-label " for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                        </div>
                        @endforeach
                        @endif

                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">XS</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">S</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">M</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">L</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">XL</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    {{-- <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button> --}}
                                    {{-- <div class="dropdown-menu dropdown-menu-right"> --}}
                                        {{-- <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a> --}}
                                        <select name="sort" id="sort" class="form-control">
                                            <option value="latest" {{ ($sort == 'latest') ? 'selected' : ''}}>Latest</option>
                                            <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : ''}}>Price High</option>
                                            <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : ''}}>Price Low</option>
                                        </select>
                                    {{-- </div> --}}
                                </div>

                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                          @php
                               $productImage = $product->product_images->first();
                          @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                @if (!empty($productImage->image))
                                <img class="img-fluid w-100" src="{{ asset('storage/uploads/product/large/'.$productImage->image) }}"   />
                                @else
                                 <img  src="{{ asset('front-assets/img/product-3.jpg') }}" alt="" class="img-fluid w-100">
                                @endif
                                <div class="product-action">
                                    @if ($product->track_qty == 'Yes')
                                    @if($product->qty > 0)
                                    <a class="btn btn-outline-dark btn-square" href="javascript:void();" onclick="addToCart({{ $product->id }});"><i class="fa fa-shopping-cart"></i></a>
                                    @else
                                    <a class="btn btn-dark" href="javascript:void();" ><i class="fa fa-shopping-cart"></i>Out of stock</a>
                                    @endif
                                    @else
                                    <a class="btn btn-outline-dark btn-square" href="javascript:void();" onclick="addToCart({{ $product->id }});"><i class="fa fa-shopping-cart"></i></a>
                                    @endif
                                    <a onclick="addToWishlist({{ $product->id }})"  class="btn btn-outline-dark btn-square" href="javascript:void(0);"><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>

                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="{{ route("front.product",$product->slug) }}">{{ $product->title }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>${{ $product->price }}</h5>
                                    @if($product->compare_prise > 0)
                                     <h6 class="text-muted ml-2"><del>${{ $product->compare_price }}</del></h6>
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
                    <div class="col-md-12 pt-5">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->


@endsection

@section('customJs')
<script>
    $(".brand-label").change(function(){
        apply_filters();
    });
    $("#sort").change(function () {
        apply_filters();
    });

    function apply_filters(){
        var brands = [];
        $(".brand-label").each(function(){
            if ($(this).is(":checked") == true) {
                brands.push($(this).val());
            }
        });

        console.log(brands.toString());
        var url = '{{  url()->current() }}?'
        var keyword = $("#search").val();

        if (keyword.lenght > 0) {
            url += '$search='+keyword;
        }

        // sorting
        // url += '$sort='.$("#sort").val()
        window.location.href = url+brands.toString();
    }

</script>
@endsection



