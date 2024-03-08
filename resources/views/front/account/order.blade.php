@extends('front.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('account.profile') }}">My Account</a>
                <span class="breadcrumb-item active">My Orders</span>
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
                        <h2 class="h5 mb-0 pt-2 pb-2">Mes Commandes</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Commande</th>
                                        <th>Date Purchased</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->isNotEmpty())
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('account.orderDetail',$order->id) }}">{{ $order->id }}</a>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                                <td>
                                                    @if($order->status == 'pending')
                                                      <span class="badge bg-danger">Pending</span>
                                                    @elseif ($order->status == 'shipped')
                                                     <span class="badge bg-info">Shipped</span>
                                                     @else
                                                     <span class="badge bg-success">Delivered</span>
                                                    @endif


                                                </td>
                                                <td>{{ $order->grand_total }}fcf</td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">Orders not found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
