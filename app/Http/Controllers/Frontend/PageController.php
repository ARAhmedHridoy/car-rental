<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $data['header_title'] = 'Home';
        $query = Car::where('availability', 1);
    
        $carTypes = Car::select('car_type')->distinct()->pluck('car_type');
        $brands = Car::select('brand')->distinct()->pluck('brand');
    
        //filters
        if ($request->filled('car_type')) {
            $query->where('car_type', $request->car_type);
        }
    
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
    
        if ($request->filled('price_max')) {
            $query->where('daily_rent_price', '<=', $request->price_max);
        }
    
      
        $data['cars'] = $query->get();
        $data['carTypes'] = $carTypes;
        $data['brands'] = $brands;
    
        return view('frontend.index', $data);
    }

    public function about(){
        $header_title = 'About US';

        return view('frontend.about', compact('header_title'));
    }
    public function contact(){
        $header_title = 'Contact US';

        return view('frontend.contact', compact('header_title'));
    }
    
}
