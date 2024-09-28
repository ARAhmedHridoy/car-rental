@extends('layouts.admin.app')

@section('content')
<div class="container-fluid px-4" style="margin-top: 15px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>Here are some admin stats:</p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>Total Cars: {{ $totalCars }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Available Cars: {{ $availableCars }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Total Rentals: {{ $totalRentals }}</h5>
                                    <small>Pending : {{ $PendingRentals }}</small>
                                    <small>Ongoing : {{ $OngoingRentals }}</small>
                                    <small>Completed : {{ $CompletedRentals }}</small>
                                    <small>Canceled : {{ $CanceledRentals }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: 10px;">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Earning: ৳{{ $totalEarnings }}</h5>
                                    <small>Next Earnings : {{ $nextEarnings }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4" style="margin-top: 10px;">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Total Customers: {{ $totalCustomers }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
