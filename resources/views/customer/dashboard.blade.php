@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Rentals</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($rentals->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Car Details</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $key => $rental)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $rental->car->name }} ({{ $rental->car->brand }})</td>
                        <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</td>
                        <td>৳{{ number_format($rental->total_cost) }}</td>
                        <td>{{ $rental->status }}</td>
                        <td>
                            @if($rental->status == 'Pending')
                                <form action="{{ route('customer.rentals.cancel', $rental->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this rental?')">Cancel</button>
                                </form>
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You have no rentals yet.</p>
    @endif
</div>
@endsection
