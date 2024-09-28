@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <h1>Manage Cars</h1>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary mb-3">Add New Car</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Car Type</th>
                <th>Daily Rent Price</th>
                <th>Availability</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $key => $car)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $car->name }}</td>
                <td>{{ $car->brand }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->car_type }}</td>
                <td>৳{{ $car->daily_rent_price }}</td>
                <td>{{ $car->availability ? 'Available' : 'Not Available' }}</td>
                <td><img src="{{ asset('images/cars/' . $car->image) }}" width="100"></td>
                <td>
                    <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-info">Edit</a>

                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection