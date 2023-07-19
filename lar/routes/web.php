<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\OwnerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//====================Customers==========================
 Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

   // Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');


    Route::get('/customers/create',[CustomerController::class, 'create'])->name('customers.create');
    
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');


   Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    
  Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');


 
  
  Route::match(['put', 'patch'],'/customers{customer}', [CustomerController::class, 'update'])->name('customers.update');

//Route::resource('reviews', ReviewController::class);





  Route::resource('houses', HouseController::class);

  Route::resource('owners', OwnerController::class);

  //=========================Review Route================================
  Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

  // Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');


   Route::get('/reviews/create',[ReviewController::class, 'create'])->name('reviews.create');
   
   Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

   Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


  Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
   
 Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');



 
 Route::match(['put', 'patch'],'/reviews{review}', [ReviewController::class, 'update'])->name('reviews.update');
