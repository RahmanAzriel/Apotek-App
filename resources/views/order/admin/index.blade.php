@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <h2 class="text-primary">Order List</h2>
        <hr>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.exportExcel')}}" class="btn btn-success">Export to Excel</a>
        <form action="" method="GET" class="form-inline">
            <div class="input-group">
                <input type="date" class="form-control" name="search_order" value="{{ request('search_order') }}" placeholder="Cari berdasarkan tanggal">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    @if(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-warning">No orders available.</div>
    @else
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Customer Name</th>
                    <th>Medicines</th>
                    <th>Jumlah Pembelian</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Cashier Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->name_customer }}</td>
                    <td>
                        <ul style="list-style: none; padding: 0;">
                            @foreach($order->medicines as $medicine)
                                <li>{{ $medicine['name_medicine'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="width: 80px;">
                        <ul style="list-style: none; padding: 0;">
                            @foreach($order->medicines as $medicine)
                                <li>{{ $medicine['qty'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>$ {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->isoFormat('dddd, D MMMM Y HH:mm:ss') }}</td>
                    <td>{{ $order->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
    @endif
</div>

<!-- Custom Styles -->
<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; /* Light gray for odd rows */
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #ffffff; /* White for even rows */
    }

    .btn-success {
        background-color: #28a745; /* Green color for export button */
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .alert {
        margin-top: 20px;
    }

    h2 {
        font-weight: bold;
    }
</style>
@endsection
