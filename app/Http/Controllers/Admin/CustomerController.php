<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header_title = 'All Customers';
        $customers = User::where('role', 'customer')->latest()->get();
        return view('admin.customers.index', compact('customers', 'header_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $header_title = 'Create New Customers';
        return view('admin.customers.create', compact('header_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15|unique:users',  // Ensure unique phone number
            'address' => 'required|string|max:255',
        ]);
    
        // Create new customer
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'role' => 'customer', // Set role as 'customer'
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $header_title = 'Customers Rental History';
        $customer = User::findOrFail($id);
        $rentalHistory = Rental::where('user_id', $id)->with('car')->get();  // Fetch rental history with car details
        return view('admin.customers.show', compact('customer', 'rentalHistory', 'header_title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $header_title = 'Edit Customers';
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer', 'header_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:15|unique:users,phone_number,' . $id,
            'address' => 'required|string',
            'password' => 'nullable|min:8|confirmed', 
        ]);
    
        $customer = User::findOrFail($id);
    
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');
        $customer->address = $request->input('address');
    
        $customer->save();
    
        return redirect()->route('admin.customers')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the customer
        $customer = User::findOrFail($id);

        // Check if the customer has any rental records
        if ($customer->rentals()->count() > 0) {
            // If the customer has rentals, return with an error message
            return redirect()->route('admin.customers')->with('error', 'You cannot delete this customer because they have rental records.');
        }

        // If the customer has no rentals, proceed with deletion
        $customer->delete();

        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully');
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Fetch rentals for the logged-in customer
        $rentals = Rental::where('user_id', $user->id)
            ->with('car') // Eager load the car relationship
            ->latest()
            ->get();

        return view('customer.dashboard', compact('rentals'));
    }

    public function cancelRental($id)
    {
        $rental = Rental::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($rental->status == 'Pending') {
            $rental->status = 'Canceled';
            $rental->save();

            return redirect()->route('dashboard')->with('success', 'Rental canceled successfully.');
        }

        return redirect()->route('dashboard')->with('error', 'Unable to cancel this rental.');
    }
}
