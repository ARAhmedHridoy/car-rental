@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <h1>Add New Car</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Car Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" name="brand" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="year">Year of Manufacture</label>
            <input type="number" name="year" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="car_type">Car Type</label>
            <input type="text" name="car_type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="daily_rent_price">Daily Rent Price</label>
            <input type="number" step="0.01" name="daily_rent_price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="availability">Availability</label>
            <select name="availability" class="form-control" required>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Car Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Add Car</button>
    </form>
</div>
@endsection