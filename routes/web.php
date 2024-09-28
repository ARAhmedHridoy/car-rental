<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.frontend.app');
// });

Route::get('/', [PageController::class, 'index'])->name('/');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/cars/filter', [App\Http\Controllers\Frontend\CarController::class, 'carsFilter'])->name('cars.filter');
Route::get('/car-details/{id}', [App\Http\Controllers\Frontend\CarController::class, 'car_details'])->name('car.details');

Route::post('/add_booking/{carId}', [App\Http\Controllers\Frontend\RentalController::class, 'bookingCar'])->name('add_booking');

Auth::routes();

Route::middleware(['auth', 'customer'])->group(function () {
    // Dashboard Route (for Customers)
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::patch('/customer/rentals/{id}/cancel', [CustomerController::class, 'cancelRental'])->name('customer.rentals.cancel');
});

// Admin Routes (Protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // cars
    Route::get('/admin/cars', [CarController::class, 'index'])->name('admin.cars');
    Route::get('/admin/cars/create', [CarController::class, 'create'])->name('admin.cars.create');
    Route::post('/admin/cars/store', [CarController::class, 'store'])->name('admin.cars.store');
    Route::get('/admin/cars/edit/{id}', [CarController::class, 'edit'])->name('admin.cars.edit');
    Route::put('/admin/cars/update/{id}', [CarController::class, 'update'])->name('admin.cars.update');
    Route::delete('/admin/cars/destroy/{id}', [CarController::class, 'destroy'])->name('admin.cars.destroy');

    //customer
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/admin/customers/show/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');
    Route::get('/admin/customers/edit/{id}', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/admin/customers/update/{id}', [CustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/admin/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    // rentals
    //Route::resource('rentals', \App\Http\Controllers\Admin\RentalController::class);
    Route::get('/admin/rentals', [RentalController::class, 'index'])->name('admin.rentals');
    Route::get('/admin/rentals/create', [RentalController::class, 'create'])->name('admin.rentals.create');
    Route::post('/admin/rentals/store', [RentalController::class, 'store'])->name('admin.rentals.store');
    Route::get('/admin/rentals/show/{id}', [RentalController::class, 'show'])->name('admin.rentals.show');
    Route::get('/admin/rentals/edit/{id}', [RentalController::class, 'edit'])->name('admin.rentals.edit');
    Route::put('/admin/rentals/update/{id}', [RentalController::class, 'update'])->name('admin.rentals.update');
    Route::delete('/admin/rentals/destroy/{id}', [RentalController::class, 'destroy'])->name('admin.rentals.destroy');
    Route::patch('admin/rentals/update-status/{id}', [RentalController::class, 'updateStatus'])->name('admin.rentals.updateStatus');
    // Route to fetch booked dates for a specific car
    Route::get('admin/rentals/booked-dates/{car_id}', [RentalController::class, 'fetchBookedDates'])->name('admin.rentals.bookedDates');
    // Route to fetch the daily rent price for a specific car
    Route::get('admin/rentals/car-daily-price/{car_id}', [RentalController::class, 'fetchCarDailyPrice'])->name('rentals.carDailyPrice');

    
});

