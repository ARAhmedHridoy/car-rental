<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header_title = 'All Cars';
        $cars = Car::latest()->get();
        return view('admin.cars.index', compact('cars', 'header_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $header_title = 'Create New Car';
        return view('admin.cars.create', compact('header_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'car_type' => 'required|string',
            'daily_rent_price' => 'required|numeric',
            'availability' => 'required|boolean',
            'image' => 'required|image|max:2048',  // Image validation
        ]);

        // Upload the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/cars'), $imagePath);
        }
        //$imagePath = $request->file('image')->store('car_images', 'public');

        // Create a new car entry
        Car::create([
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'model' => $validatedData['model'],
            'year' => $validatedData['year'],
            'car_type' => $validatedData['car_type'],
            'daily_rent_price' => $validatedData['daily_rent_price'],
            'availability' => $validatedData['availability'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.cars')->with('success', 'Car added successfully');
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
        $header_title = 'Edit';
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car', 'header_title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'car_type' => 'required|string',
            'daily_rent_price' => 'required|numeric',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $car = Car::findOrFail($id);

        $imagePath = $car->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imagePath = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/cars'), $imagePath);

            if ($car->image && file_exists(public_path('images/cars/' . $car->image))) {
                unlink(public_path('images/cars/' . $car->image));
            }
        }

        $car->update([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'car_type' => $request->input('car_type'),
            'daily_rent_price' => $request->input('daily_rent_price'),
            'availability' => $request->boolean('availability'), 
            'image' => $imagePath, 
        ]);
    
        return redirect()->route('admin.cars')->with('success', 'Car updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);

        if($car->rentals()->count() > 0){
            return redirect()->route('admin.cars')->with('error', 'You cannot delete this Car because this have rental records.'); 
        }
        $car->delete();
        return redirect()->route('admin.cars')->with('success', 'Car deleted successfully');
    }
}
