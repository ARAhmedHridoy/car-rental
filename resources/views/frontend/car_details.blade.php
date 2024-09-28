@extends('layouts.frontend.app')

@section('content')
<!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Car Detail</h1>
        <div class="d-inline-flex text-white">
            <h6 class="text-uppercase m-0"><a class="text-white" href="{{ route('/') }}">Home</a></h6>
            <h6 class="text-body m-0 px-3">/</h6>
            <h6 class="text-uppercase text-body m-0">Car Detail</h6>
        </div>
    </div>
    <!-- Page Header Start -->


    <!-- Detail Start -->
    <div class="container-fluid pt-5">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <h1 class="display-4 text-uppercase mb-5">{{ $car->name }}</h1>
                    <div class="row mx-n2 mb-3">
                        <div class="col-md-10 col-12 px-2 pb-2">
                            <img class="img-fluid w-100" src="{{ asset('images/cars/' . $car->image) }}" alt="{{ $car->name }}">
                        </div>
                    </div>
                    <p>Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor consetetur takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam dolores dolore. Amet erat amet et magna</p>
                    <div class="row pt-2">
                        <div class="col-md-3 col-6 mb-2">
                            <i class="fa fa-car text-primary mr-2"></i>
                            <span>Brand: {{ $car->brand }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <i class="fa fa-cogs text-primary mr-2"></i>
                            <span>Year: {{ $car->year }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <i class="fa fa-eye text-primary mr-2"></i>
                            <span>Model: {{ $car->model }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <i class="fa fa-road text-primary mr-2"></i>
                            <span>Rent: {{ $car->daily_rent_price }}/day</span>
                        </div>
                    </div>
            </div>

                <div class="col-lg-4 mb-5">
                    <div class="bg-secondary p-5">
                        <h3 class="text-primary text-center mb-4">Book This Car</h3>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ url('add_booking', $car->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="total_cost" id="hidden_total_cost" value="{{ $car->total_cost }}">
                            
                            <div class="form-group">
                                <div class="date" id="date1" data-target-input="nearest">
                                    <input type="text" name="start_date" value="{{ old('start_date') }}" id="start_date" class="form-control" placeholder="Start Date" required>
                                    <span style="color:red;">{{ $errors->first('start_date') }}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="date" id="date2" data-target-input="nearest">
                                    <input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date" required>
                                    <span style="color:red;">{{ $errors->first('end_date') }}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <p class="form-control" id="duration">Duration: <span>0 days</span></p>
                            </div>
                            <div class="form-group">
                                <p class="form-control" id="total_cost">Total Cost: <span>৳0</span></p>
                            </div>
                            
                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-block" type="submit" style="height: 50px;">Book Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->


    <!-- Related Car Start -->
    <div class="container-fluid pb-5">
        <div class="container pb-5">
            <h2 class="mb-4">Related Cars</h2>
            
            <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                    @foreach ($relatedCars as $cars)
                    <div class="rent-item">
                        <img class="img-fluid mb-4" src="{{ asset('images/cars/' . $cars->image) }}" alt="{{ $cars->name }}">
                        <h4 class="text-uppercase mb-4">{{ $cars->name }}</h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-primary mr-1"></i>
                                <span>{{ $cars->brand }}</span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-primary mr-1"></i>
                                <span>{{ $cars->year }}</span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-primary mr-1"></i>
                                <span>{{ $cars->model }}</span>
                            </div>
                        </div>
                        <a class="btn btn-primary px-3" href="{{ $cars->id }}">৳{{ $cars->daily_rent_price }}/Day</a>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
    <!-- Related Car End -->
@endsection

@section('script')

<script>
    $(function() {   
       var unavailableDates = @json($unavailableDates);
       
       function disableDates (date) {
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            
            if (date < today || unavailableDates.indexOf(string) != -1){
               return [false];
            } else {
               return [true];
            }
        }

        $("#start_date, #end_date").datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: disableDates
        });
    });
</script>
<!-- Script for Calculating Total Cost -->
<script>
    $(document).ready(function() {
        $('#start_date, #end_date').change(function() {
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());

            if (startDate && endDate && startDate <= endDate) {
                var duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                var pricePerDay = {{ $car->daily_rent_price }};
                var totalPrice = duration * pricePerDay;

                $('#duration span').text(duration + ' days');
                $('#total_cost span').text('৳' + totalPrice);
            } else {
                $('#duration span').text('0 days');
                $('#total_cost span').text('৳0');
            }
        });
    });

    document.getElementById("mobile_submit_button").addEventListener("click", function() {
        document.getElementById("reservation_form").submit();
    });
</script>

@endsection