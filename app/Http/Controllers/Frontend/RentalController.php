<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalDetailsToCustomer;
use App\Mail\RentalNotificationToAdmin;

class RentalController extends Controller
{
    public function bookingCar(Request $request, $carId)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);


        $car = Car::find($carId);
        if (!$car) {
            return redirect()->back()->withErrors(['error' => 'Car does not exist.']);
        }

        if (Auth::check()) {
            # code...
            // Calculate the number of days between start_date and end_date
            $startDate = \Carbon\Carbon::parse($request->start_date);
            $endDate = \Carbon\Carbon::parse($request->end_date);
            $numberOfDays = $startDate->diffInDays($endDate) + 1; // Include both start and end date

            // Calculate the total cost (daily rent price * number of days)
            $totalCost = $numberOfDays * $car->daily_rent_price;

            $rental = Rental::create([
                'car_id' => $carId,
                'user_id' => Auth::id(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_cost' => $totalCost,
            ]);

            $customerEmail = Auth::user()->email; 
            $customerName = Auth::user()->name;
            $customerPhone = Auth::user()->phone_number;
            $customerAddress = Auth::user()->address;
            $status = 'Pending';
            $total_cost = $totalCost;
            // Send emails
            try {
                Mail::to($customerEmail)->send(new RentalDetailsToCustomer($customerName, $rental, $total_cost, $status));
                    Mail::to('hridoyahmed51@gmail.com')->send(new RentalNotificationToAdmin($customerEmail, $customerName, $customerPhone, $customerAddress, $rental, $status));
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        } else {
            # code...
            return redirect()->route('login')->with('error', 'Login Your Account for Booking Cars!');
        }
        

        return redirect()->route('car.details', $carId)->with('success', 'Car Booking Successful!');
    }

    
}
