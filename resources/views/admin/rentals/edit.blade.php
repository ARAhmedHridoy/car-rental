@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="rentalForm" action="{{ route('admin.rentals.update', $rental->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">Customer</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $rental->user_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} ({{ $customer->email }}) ({{ $customer->phone_number }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="car_id">Car</label>
            <select name="car_id" id="car_id" class="form-control">
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ $rental->car_id == $car->id ? 'selected' : '' }}>
                        {{ $car->name }} ({{ $car->brand }}) - {{ $car->daily_rent_price }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="text" name="start_date" id="start_date" class="form-control" autocomplete="off" value="{{ $rental->start_date }}" readonly>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="text" name="end_date" id="end_date" class="form-control" autocomplete="off" value="{{ $rental->end_date }}" readonly>
        </div>

        <div class="form-group">
            <label for="total_cost">Total Cost</label>
            <input type="text" name="total_cost" id="total_cost" class="form-control" value="{{ $rental->total_cost }}" readonly>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Pending" {{ $rental->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Ongoing" {{ $rental->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Completed" {{ $rental->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Canceled" {{ $rental->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"  style="margin-top: 20px;">Update Rental</button>
        <a href="{{ route('admin.rentals') }}" class="btn btn-secondary"  style="margin-top: 20px;">Back</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var dailyRentPrice = 0;
    var existingBookedDates = @json($bookedDates); // Booked dates from the controller
    var rentalStartDate = '{{ $rental->start_date }}';
    var rentalEndDate = '{{ $rental->end_date }}';

    // Function to initialize or update the date pickers
    function initializeDatePickers(bookedDates) {
        function disableDates(date) {
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);

            if (date < today || bookedDates.indexOf(string) !== -1) {
                return [false];
            } else {
                return [true];
            }
        }

        $("#start_date, #end_date").datepicker("destroy").datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: disableDates,
            onSelect: calculateTotalCost
        }).datepicker('setDate', new Date(rentalStartDate));
        
        $("#end_date").datepicker('setDate', new Date(rentalEndDate));
    }

    initializeDatePickers(existingBookedDates);

    // Event listener for when the car is changed
    $('#car_id').change(function() {
        var carId = $(this).val();
        
        $('#start_date, #end_date').val(''); // Clear the date pickers
        $('#total_cost').val(''); // Clear the total cost

        if (carId) {
            // AJAX request to fetch booked dates for the selected car
            $.get("{{ url('admin/rentals/booked-dates') }}/" + carId, function(data) {
                var bookedDates = data;
                initializeDatePickers(bookedDates);

                // Get daily rent price for selected car
                $.get("{{ url('admin/rentals/car-daily-price') }}/" + carId, function(dailyPriceData) {
                    dailyRentPrice = dailyPriceData.dailyRentPrice;
                    calculateTotalCost(); // Recalculate total cost if dates are selected
                });
            });
        } else {
            dailyRentPrice = 0;
            initializeDatePickers([]); // Reset the date pickers
        }
    });

    // Function to calculate total cost
    function calculateTotalCost() {
        var startDate = $('#start_date').datepicker('getDate');
        var endDate = $('#end_date').datepicker('getDate');

        if (startDate && endDate && dailyRentPrice > 0) {
            var days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1; // Include start and end dates
            if (days > 0) {
                var totalCost = days * dailyRentPrice;
                $('#total_cost').val(totalCost.toFixed(2));
            } else {
                $('#total_cost').val(''); // Reset if dates are invalid
            }
        }
    }

    $('#start_date, #end_date').change(calculateTotalCost); // Trigger cost calculation when dates are changed
});
</script>
@endsection