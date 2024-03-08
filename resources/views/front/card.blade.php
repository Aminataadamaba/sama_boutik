@extends('front.layouts.app')

@section('content')

 <!-- Breadcrumb Start -->
 <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('front.home') }}">Home</a>
                <a class="breadcrumb-item text-dark" href="{{ route('front.shop') }}">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Cart Start -->
<div class="container-fluid">
    @if(Session::has('success'))
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! Session::get('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
    </div>
    @endif
    @if(Cart::count() > 0)
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">

                    @foreach ($cartContent as $item)
                    <tr>

                        <td class="d-flex align-items-center">
                        @if (!empty($item->options->productImage->image))
                        <img style="width: 50px;" class="img-fluid" src="{{ asset('storage/uploads/product/large/'.$item->options->productImage->image) }}"  />
                        @else
                        <img class="img-fluid" src="{{ asset('front-assets/img/product-5.jpg') }}" alt="" />
                        @endif

                        <td class="align-middle"> {{$item->name}}</td></td>
                        <td class="align-middle">{{ $item->price }} fcf</td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus sub" data-id="{{ $item->rowId }}">
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $item->qty }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus add" data-id="{{ $item->rowId }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">{{ $item->price*$item->qty }} fcf</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger" onclick="deleteItem('{{ $item->rowId }}');"><i class="fa fa-times"></i></button></td>
                        @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-30" action="">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>{{ Cart::subtotal() }} fcf</h6>
                    </div>

                </div>
                <div class="pt-2">
                    <a href="{{ route('front.checkout') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-center align-items-center">
                <h4> Your cart is empty!</h4>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- Cart End -->


@endsection

@section('customJs')
<script>
    $('.add').click(function(){
      var qtyElement = $(this).parent().prev(); // Qty Input
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue < 10) {
         var rowId = $(this).data('id');
          qtyElement.val(qtyValue+1);
          var newQty = qtyElement.val();
          updateCart(rowId,newQty)
      }
  });

  $('.sub').click(function(){
      var qtyElement = $(this).parent().next();
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue > 1) {
        var rowId = $(this).data('id');
          qtyElement.val(qtyValue-1);
          var newQty = qtyElement.val();
          updateCart(rowId,newQty)
      }
  });

  function updateCart(rowId,qty) {
    $.ajax({
        url: '{{ route("front.updateCart") }}',
        type: 'post',
        data: {rowId:rowId, qty:qty},
        dataType: 'json',
        success: function(response) {
            window.location.href = '{{ route("front.cart") }}';
        }
    });

  }

  function deleteItem(rowId) {

    if (confirm("Are you sure you want to delete?")) {
        $.ajax({
        url: '{{ route("front.deleteItem.cart") }}',
        type: 'post',
        data: {rowId:rowId},
        dataType: 'json',
        success: function(response) {
            window.location.href = '{{ route("front.cart") }}';
        }
    });
    }


  }
</script>


@endsection
