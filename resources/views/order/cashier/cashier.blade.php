@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <p><span class="text-muted">yang melayani:</span> <span class="font-weight-bold">{{ Auth::user()->name }}</span></p>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Order List</h2>
        <a href="{{ route('purchase.form') }}" class="btn btn-success">+ Add Order</a>
    </div>
    <hr class="mb-4">

    <form action="{{ route('purchase.index') }}" method="GET" class="form-inline mb -4">
        <div class="input-group">
            <input type="date" class="form-control" name="search_order" value="{{ request('search_order') }}" placeholder="Cari berdasarkan tanggal">
            <div class="input-group-append gap-1">
                <button class="btn btn-outline-primary" type="submit">Search</button>
                <a href="{{ route('purchase.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    @if(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-warning">No orders available.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Medicines</th>
                        <th>Jumlah Pembelian</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Cashier Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->name_customer }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($order->medicines as $medicine)
                                    <li>{{ $medicine['name_medicine'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($order->medicines as $medicine)
                                    <li>{{ $medicine['qty'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>$ {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->isoFormat('dddd, D MMMM Y HH:mm:ss') }}</td>
                        <td>{{ Auth::user()->name }}</td>
                        <td>
                            <a href="{{ route('purchase.download_pdf', $order['id']) }}" class="btn btn-info btn-sm">PDF Print</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
