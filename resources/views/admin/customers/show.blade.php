@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <h1>{{ $customer->name }}'s Rental History</h1>

    <a href="{{ route('admin.customers') }}" class="btn btn-secondary mb-3">Back to Customers</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentalHistory as $key => $rental)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $rental->car->name }} ({{ $rental->car->brand }})</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>৳{{ $rental->total_cost }}</td>
                <td>{{ $rental->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection