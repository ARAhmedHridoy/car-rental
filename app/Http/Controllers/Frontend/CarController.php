<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function carsFilter(Request $request)
    {
        
        $header_title = 'Filters Car';
        $carType = $request->input('car_type');
        $brand = $request->input('brand');
        $priceMax = $request->input('price_max');

        // Build the query
        $query = Car::query();

        if ($carType) {
            $query->where('car_type', $carType);
        }

        if ($brand) {
            $query->where('brand', $brand);
        }

        if ($priceMax) {
            $query->where('daily_rent_price', '<=', $priceMax);
        }

        // Get filtered cars
        $cars = $query->where('availability', 1)->get();

        // Pass the filtered cars and other necessary data back to the view
        return view('frontend.index', [
            'header_title' => $header_title,
            'cars' => $cars,
            'carTypes' => Car::distinct()->pluck('car_type'),
            'brands' => Car::distinct()->pluck('brand')
        ]);
    }

    public function car_details($id)
    {
        $header_title = 'Car Details';
        $car = Car::where('id', $id)->where('availability', 1)->firstOrFail();

        // Fetch unavailable dates for this car (for rental purposes)
        $unavailableDates = Rental::whereIn('status', ['Pending', 'Ongoing'])
            ->where('car_id', $car->id)
            ->get()
            ->flatMap(function ($rental) {
                return $this->getDateRange($rental->start_date, $rental->end_date);
            })
            ->unique()
            ->values()
            ->toArray();

        // Fetch related cars (same brand or car type) but exclude the current car
        $relatedCars = Car::where('availability', 1)
            ->where('id', '!=', $car->id)
            ->where(function ($query) use ($car) {
                $query->where('brand', $car->brand)
                    ->orWhere('car_type', $car->car_type);
            })
            ->take(6) // Limit to 5 related cars, you can adjust this number
            ->get();

        // Pass data to the view
        return view('frontend.car_details', compact('header_title','car', 'unavailableDates', 'relatedCars'));
    }

    private function getDateRange($start_date, $end_date)
    {
        $dates = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);

        while ($current <= $end) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }
}
