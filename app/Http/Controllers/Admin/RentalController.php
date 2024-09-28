<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalDetailsToCustomer;
use App\Mail\RentalNotificationToAdmin;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header_title = 'All Rentals';
        // Fetch all rentals with their related car and user data
        $rentals = Rental::with('car', 'user')->latest()->get();
        return view('admin.rentals.index', compact('rentals', 'header_title'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function fetchBookedDates($car_id)
    {
        // Fetch booked rentals for the selected car
        $bookings = Rental::where('car_id', $car_id)->select('start_date', 'end_date')->get();

        $bookedDates = [];

        foreach ($bookings as $booking) {
            // Create a range of dates between start_date and end_date
            $range = Carbon::parse($booking->start_date)->toPeriod($booking->end_date);
            foreach ($range as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        return response()->json($bookedDates);  // Return the booked dates as JSON
    }
    public function fetchCarDailyPrice($car_id)
    {
        $car = Car::find($car_id);
        if ($car) {
            return response()->json(['dailyRentPrice' => $car->daily_rent_price]);
        } else {
            return response()->json(['dailyRentPrice' => 0], 404); // Return 0 if car is not found
        }
    }
    public function create()
    {
        $header_title = 'Create New Rentals';
        $cars = Car::where('availability', true)->get();
        $customers = User::where('role', 'customer')->get();
        // Initialize empty booked dates array for when no car is selected
        $bookedDates = [];
        return view('admin.rentals.create', compact('cars', 'customers', 'bookedDates', 'header_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the input data
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'car_id' => 'required|exists:cars,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:Pending,Ongoing,Completed,Canceled'
    ]);

    // Get the selected car's details
    $car = Car::find($request->car_id);

    // Calculate the number of days between start_date and end_date
    $startDate = \Carbon\Carbon::parse($request->start_date);
    $endDate = \Carbon\Carbon::parse($request->end_date);
    $numberOfDays = $startDate->diffInDays($endDate) + 1; // Include both start and end date

    // Calculate the total cost (daily rent price * number of days)
    $totalCost = $numberOfDays * $car->daily_rent_price;

    // Store the rental in the database
    $rental = new Rental();
    $rental->car_id = $request->car_id;
    $rental->user_id = $request->user_id;
    $rental->start_date = $request->start_date;
    $rental->end_date = $request->end_date;
    $rental->total_cost = $totalCost; // Automatically calculated total cost
    $rental->status = $request->status;
    $rental->save();

    $customer = User::find($request->user_id);

         $customerEmail = $customer->email; 
         $customerName = $customer->name;
         $customerPhone = $customer->phone_number;
         $customerAddress = $customer->address;
         $status = $request->status;
         $total_cost = $totalCost;
         // Send emails
         try {
             Mail::to($customerEmail)->send(new RentalDetailsToCustomer($customerName, $rental, $total_cost, $status));
             Mail::to('hridoyahmed51@gmail.com')->send(new RentalNotificationToAdmin($customerEmail, $customerName, $customerPhone, $customerAddress, $rental, $status));
         } catch (\Exception $e) {
             Log::error('Email sending failed: ' . $e->getMessage());
         }

    return redirect()->route('admin.rentals')->with('success', 'Rental created successfully with total cost calculated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $header_title = 'Edit Rental';
    $rental = Rental::findOrFail($id);  // Find the rental by ID
    $cars = Car::where('availability', true)->get();
    $customers = User::where('role', 'customer')->get();
    
    // Fetch the booked dates for the car associated with this rental
    $bookings = Rental::where('car_id', $rental->car_id)
                      ->where('id', '!=', $id)  // Exclude current rental to allow editing its dates
                      ->select('start_date', 'end_date')
                      ->get();

    $bookedDates = [];
    foreach ($bookings as $booking) {
        $range = Carbon::parse($booking->start_date)->toPeriod($booking->end_date);
        foreach ($range as $date) {
            $bookedDates[] = $date->format('Y-m-d');
        }
    }

    // Pass rental and booked dates to the view
    return view('admin.rentals.edit', compact('rental', 'cars', 'customers', 'bookedDates', 'header_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Ongoing,Completed,Canceled',
        ]);

        // Find the rental record
        $rental = Rental::findOrFail($id);

        // Calculate total cost based on the number of days
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $days = $start_date->diffInDays($end_date) + 1;

        $car = Car::find($request->car_id);
        $total_cost = $car->daily_rent_price * $days;

        // Update the rental record with new data
        $rental->update([
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $total_cost,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.rentals')->with('success', 'Rental updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();
        return redirect()->route('admin.rentals')->with('success', 'Rental deleted successfully');
        
    }

    public function updateStatus(Request $request, $id)
    {
        // Find the rental by ID
        $rental = Rental::findOrFail($id);

        // Update the rental status
        $rental->status = $request->input('status');
        $rental->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}
