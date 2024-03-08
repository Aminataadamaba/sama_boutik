@extends('admin.layouts.app')

@section('title', 'List Category')

@section('content')

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h1>Commande</h1>

                </div>
            </div>
        </div>


        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

        <div class="container-fluid">
             @include('admin.message')

            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="d-flex align-items-center justify-content-between">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ route('orders.index') }}'" class="btn btn-default btn-sm">Reset</button>
                            </div>
                            <div class="input-group input-group" style="width: 250px;">
                                <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append" style="background: #d5cfce; color: #fff;">
                                    <button type="submit" class="btn btn-default text-dark">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>

                    <div class="card-body table-responsive p-3">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>N° Commande</th>
                                <th >Client</th>
                                <th >Email</th>
                                <th >Phone</th>
                                <th >Status</th>
                                <th >Montant</th>
                                <th >Date D'achat</th>
                                <th>Date D'expedition</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($orders->isNotEmpty())

                            @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.detail',[$order->id]) }}">{{ $order->id }}</a></td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->mobile }}</td>
                                <td>
                                    @if ($order->status == 'pending')
                                    <span class="badge bg-danger">En attente</span>
                                    @elseif ($order->status == 'shipped')
                                      <span class="badge bg-info">Expedie</span>
                                    @elseif($order->status == 'delivered')
                                      <span class="badge bg-success">Livre</span>
                                    @else
                                      <span class="badge bg-danger">Annuler</span>
                                     @endif

                                </td>
                                <td>{{ $order->grand_total }} Fcf</td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                <td> @if(!empty($order->shipped_date))
                                    {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') }}
                                   @else
                                   Indisponible
                                   @endif</td>
                            </tr>


                            @endforeach


                               <tr>
                                <td colspan="5">Enregistrement introuvables</td>
                               </tr>

                            @endif
                       </tbody>
                    </table>
                </div>
                <br><br><br><br><br><br><br>

                <div class="card-footer clearfix">

                    {{ $orders->links() }}

                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->



@endsection

@section('customJs')
<script>
</script>

@endsection



