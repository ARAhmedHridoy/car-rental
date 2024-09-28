@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <h2>Manage Rentals</h2>
    <a href="{{ route('admin.rentals.create') }}" class="btn btn-primary mb-3">Add New Rental</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Customer Name</th>
                <th>Car Details</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $key => $rental)
                <tr id="rental-{{ $rental->id }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $rental->user->name }}</td>
                    <td>{{ $rental->car->name }} ({{ $rental->car->brand }})</td>
                    <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</td>
                    <td>৳{{ $rental->total_cost }}</td>
                    <td>
                        <select class="form-control status-select" data-id="{{ $rental->id }}">
                            <option value="Pending" {{ $rental->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Ongoing" {{ $rental->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $rental->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Canceled" {{ $rental->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('admin.rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.rentals.destroy', $rental->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-select').change(function() {
            var rentalId = $(this).data('id');
            var status = $(this).val();

            $.ajax({
                url: "{{ url('admin/rentals/update-status') }}/" + rentalId,
                type: "PATCH",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        alert(response.message);
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function() {
                    alert('Error updating status.');
                }
            });
        });
    });
</script>
@endsection