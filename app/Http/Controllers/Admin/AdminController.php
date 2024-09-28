<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $header_title = 'Dashboard';
        // Get data to display on the admin dashboard
        $totalCars = Car::count();
        $availableCars = Car::where('availability', '1')->count();
        $totalRentals = Rental::count();
        $PendingRentals = Rental::where('status', 'Pending')->count();
        $OngoingRentals = Rental::where('status', 'Ongoing')->count();
        $CompletedRentals = Rental::where('status', 'Completed')->count();
        $CanceledRentals = Rental::where('status', 'Canceled')->count();
        $totalEarnings = Rental::where('status', 'Completed')->sum('total_cost');
        $nextEarnings = Rental::where('status', 'Ongoing')->sum('total_cost');
        $totalCustomers = User::where('role', 'customer')->count();

        return view('admin.dashboard', compact('totalCars', 'availableCars', 'totalRentals', 'PendingRentals', 'OngoingRentals', 'CompletedRentals', 'CanceledRentals', 'totalCustomers', 'totalEarnings', 'nextEarnings', 'header_title'));
    }
}
