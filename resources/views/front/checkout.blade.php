@extends('front.layouts.app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('front.home') }}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('front.shop') }}">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <form action="" id="orderForm" name="orderForm" method="post">
            @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="First_name" name="first_name" id="first_name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Last_name" name="last_name" id="last_name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" placeholder="example@email.com" name="email" id="email" value="{{ (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="Mobile" name="mobile" id="mobile" value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address</label>
                            <input class="form-control" type="text" placeholder="Adresse" name="address" id="address" value="{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}">
                            <p></p>
                        </div>
                           <div class="col-md-6 form-group">
                                <label for="">Appartment</label>
                                <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : '' }}">
                                <p></p>
                            </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select" name="country" id="country">
                                <option>Select a Country</option>
                                @if($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                      <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                @endif
                                <p></p>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="Dakar" name="city" id="city" value="{{ (!empty($customerAddress)) ? $customerAddress->city : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="Dakar" name="state" id="state" value="{{ (!empty($customerAddress)) ? $customerAddress->state : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123" name="zip" id="zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : '' }}">
                            <p></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="mb-3">
                                <textarea name="notes" id="notes" cols="30" rows="3" placeholder="Notes" class="form-control" value=""></textarea>
                                <p></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-5">

                    <div class="border-bottom">

                        <h6 class="mb-3">Products</h6>
                        @foreach (Cart::content() as $item)
                        <div class="d-flex justify-content-between">
                            <p>{{ $item->name }} X {{ $item->qty }}</p>
                            <p>${{ $item->price*$item->qty }}</p>
                        </div>

                      @endforeach
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>${{ Cart::subtotal() }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium"><strong id="ShippingAmount">${{ number_format($totalShippingCharge,2) }}</strong></h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><strong id="grandTotal">${{ number_format( $grandTotal,2)}}</strong></h5>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative mb-3"><span class="bg-secondary pr-3">Payment Method</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input checked type="radio" name="payment_method" value="cod" id="payment_method_one" class="custom-control-input">
                                <label for="payment_method_one" class="custom-control-label">Orange Money</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_two" class="custom-control-input">
                                <label for="payment_method_two" class="custom-control-label">Wave</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="paypal" value="cod">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="card-body p-0 d-none mt-3" id="card-payment-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="cvv_code" class="mb-2">CVV Code</label>
                                    <input type="text" name="cvv_code" id="cvv_code" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
    </div>
    <!-- Checkout End -->

@endsection

@section('customJs')
<script>
        $("#payment_method_one").click(function () {
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").addClass('d-none');
        }
    });

    $("#payment_method_two").click(function () {
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").addClass('d-none');
        }
    });

    $("#paypal").click(function () {
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").removeClass('d-none');
        }
    });

    $("#orderForm").submit(function(event){
        event.preventDefault();
        $('button[type="submit"]').prop('disabled',true);
        $.ajax({
        url: '{{ route("front.processCheckout") }}',
        type: 'post',
        data: $(this).serializeArray(),
        dataType: 'json',
        success: function(response) {
            var errors = response.errors;
            $('button[type="submit"]').prop('disabled',false);

            //front.thankyou
            if (response.status == false) {
                    if (errors.first_name) {
                            $("#first_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.first_name);
                        }else{
                            $("#first_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.last_name) {
                            $("#last_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.last_name);
                        }else{
                            $("#last_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }

                    if (errors.email) {
                            $("#email").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.email);
                        }else{
                            $("#email").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }

                    if (errors.password) {
                            $("#password").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.password);
                        }else{
                            $("#password").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }

                    if (errors.country) {
                            $("#country").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.country);
                        }else{
                            $("#country").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.state) {
                            $("#state").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.state);
                        }else{
                            $("#state").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.zip) {
                            $("#zip").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.zip);
                        }else{
                            $("#zip").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.address) {
                            $("#address").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.address);
                        }else{
                            $("#address").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.mobile) {
                            $("#mobile").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.mobile);
                        }else{
                            $("#mobile").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.apartment) {
                            $("#apartment").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.apartment);
                        }else{
                            $("#apartment").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
                    if (errors.city) {
                            $("#city").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.city);
                        }else{
                            $("#city").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('');
                    }
            }else {
                window.location.href="{{ url('/thanks/') }}/"+response.orderId;
            }
        }


    });

    });

    $("#country").change(function(){
        $.ajax({
        url: '{{ route("front.getOrderSummery") }}',
        type: 'post',
        data: {country_id: $(this).val()},
        dataType: 'json',
        success: function(response){

            if (response.status == true){
                $("#ShippingAmount").html('$'+respone.shippingCharge);
                $("#grandTotal").html('$'+respone.grandTotal);

            }

        }
    });
    });
</script>
@endsection
