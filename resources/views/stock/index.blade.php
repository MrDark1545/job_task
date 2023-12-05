@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">stocks</h1>
            <div class="row">
              
                <div class="col-md-6">
                    <a href="{{ route('stock.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i> Export
                    </a>
                </div>
                
            </div>

        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Email</th>
                                <th width="20%">First Order</th>
                                <th width="20%">Last Order</th>
                                <th width="10%">Total Order</th>
                                <th width="10%">Total Quantity</th>
                                <th width="25%">Days Difference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $row)
                                <tr>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->first_order }}</td>
                                    <td>{{ $row->last_order }}</td>
                                    <td>{{ $row->total_orders }}</td>
                                    <td>{{ $row->total_quantity }}</td>
                                    <td>{{ $row->day_diff }}</td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $result->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    
@endsection
