@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <h2>Add New Rental</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rentals.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="user_id">Customer</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }}) ({{ $customer->phone_number }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="car_id">Car</label>
            <select name="car_id" id="car_id" class="form-control" required>
                <option value="">Select Car</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->brand }}) - {{ $car->daily_rent_price }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="text" name="start_date" value="{{ old('start_date') }}" id="start_date" class="form-control" placeholder="Start Date" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
        </div>

        <div class="form-group">
            <label for="total_cost">Total Cost</label>
            <input type="text" id="total_cost" class="form-control" readonly required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Pending">Pending</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
                <option value="Canceled">Canceled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create Rental</button>
        <a href="{{ route('admin.rentals') }}" class="btn btn-secondary"  style="margin-top: 20px;">Back</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var dailyRentPrice = 0;

        // Function to initialize or update the date pickers
        function initializeDatePickers(bookedDates) {
            function disableDates(date) {
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Set time to 00:00 for accurate date comparison
                var string = jQuery.datepicker.formatDate('yy-mm-dd', date); // Format date to 'yyyy-mm-dd'
                
                // Disable past dates and already booked dates
                if (date < today || bookedDates.indexOf(string) !== -1) {
                    return [false];
                } else {
                    return [true];
                }
            }

            // Reinitialize the date pickers for start_date and end_date
            $("#start_date, #end_date").datepicker("destroy").datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: disableDates,
                onSelect: calculateTotalCost // Trigger total cost calculation when dates are selected
            });
        }

        // Event listener for when the car is changed
        $('#car_id').change(function() {
            var carId = $(this).val();
            
            // Reset start_date, end_date, and total_cost when the car is changed
            $('#start_date, #end_date').val(''); // Clear the date pickers
            $('#total_cost').val(''); // Clear the total cost

            if (carId) {
                // AJAX request to fetch the booked dates for the selected car
                $.get("{{ url('admin/rentals/booked-dates') }}/" + carId, function(data) {
                    var bookedDates = data; // Booked dates array

                    // Initialize date pickers with the new booked dates
                    initializeDatePickers(bookedDates);

                    // Get the daily rent price for the selected car from the server
                    $.get("{{ url('admin/rentals/car-daily-price') }}/" + carId, function(dailyPriceData) {
                        dailyRentPrice = dailyPriceData.dailyRentPrice;
                    });
                });
            } else {
                // If no car is selected, reset the date pickers and dailyRentPrice
                dailyRentPrice = 0;
                initializeDatePickers([]);
            }
        });

        // Function to calculate total cost
        function calculateTotalCost() {
            var startDate = $('#start_date').datepicker('getDate');
            var endDate = $('#end_date').datepicker('getDate');

            if (startDate && endDate && dailyRentPrice > 0) {
                var days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1; // Include both start and end dates
                if (days > 0) {
                    var totalCost = days * dailyRentPrice;
                    $('#total_cost').val(totalCost.toFixed(2)); // Display total cost in the field
                } else {
                    $('#total_cost').val(''); // Reset if dates are invalid
                }
            }
        }

        // Listen for changes in date fields to recalculate total cost
        $('#start_date, #end_date').change(calculateTotalCost);
    });
</script>
@endsection
