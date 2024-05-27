<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BorderController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;


Route::view('/', 'auth.login');

Route::middleware(['auth'])->group(function () {

Route::get('/country', CountryController::class .'@index')->name('countries.index');
Route::get('/countries/create', CountryController::class . '@create')->name('countries.create');
Route::post('/countries', CountryController::class .'@store')->name('countries.store');
Route::get('/countries/{country}', CountryController::class .'@show')->name('countries.show');
Route::get('/countries/{country}/edit', CountryController::class .'@edit')->name('countries.edit');
Route::post('/countries/{country}', CountryController::class .'@update')->name('countries.update');
Route::delete('/countries/{country}', CountryController::class .'@destroy')->name('categories.destroy');

Route::get('/city', CityController::class .'@index')->name('cities.index');
Route::get('/cities/create', CityController::class . '@create')->name('cities.create');
Route::post('/cities', CityController::class .'@store')->name('cities.store');
Route::get('/cities/{city}', CityController::class .'@show')->name('cities.show');
Route::get('/cities/{city}/edit', CityController::class .'@edit')->name('cities.edit');
Route::put('/cities/{city}', CityController::class .'@update')->name('cities.update');
Route::delete('/cities/{city}', CityController::class .'@destroy')->name('cities.destroy');


Route::get('/borders', BorderController::class .'@index')->name('borders.index');
Route::get('/borders/create', BorderController::class . '@create')->name('borders.create');
Route::post('/borders', BorderController::class .'@store')->name('borders.store');
Route::get('/borders/{border}', BorderController::class .'@show')->name('borders.show');
Route::get('/borders/{border}/edit', BorderController::class .'@edit')->name('borders.edit');
Route::put('/borders/{border}', BorderController::class .'@update')->name('borders.update');
Route::delete('/borders/{border}', BorderController::class .'@destroy')->name('borders.destroy');


Route::get('/lanes', RouteController::class .'@index')->name('lanes.index');
Route::get('/lanes/create', RouteController::class . '@create')->name('lanes.create');
Route::post('/lanes', RouteController::class .'@store')->name('lanes.store');
Route::get('/lanes/{lane}', RouteController::class .'@show')->name('lanes.show');
Route::get('/lanes/{lane}/edit', RouteController::class .'@edit')->name('lanes.edit');
Route::put('/lanes/{lane}', RouteController::class .'@update')->name('lanes.update');
Route::delete('/lanes/{lane}', RouteController::class .'@destroy')->name('lanes.destroy');


Route::get('/customers', CustomerController::class .'@index')->name('customers.index');
Route::get('/customers/create', CustomerController::class . '@create')->name('customers.create');
Route::post('/customers', CustomerController::class .'@store')->name('customers.store');
Route::get('/customers/{customer}', CustomerController::class .'@show')->name('customers.show');
Route::get('/customers/{customer}/edit', CustomerController::class .'@edit')->name('customers.edit');
Route::put('/customers/{customer}', CustomerController::class .'@update')->name('customers.update');
Route::delete('/customers/{customer}', CustomerController::class .'@destroy')->name('customers.destroy');

Route::get('/transporters', TransporterController::class .'@index')->name('transporters.index');
Route::get('/transporters/create', TransporterController::class . '@create')->name('transporters.create');
Route::post('/transporters', TransporterController::class .'@store')->name('transporters.store');
Route::get('/transporters/{transporter}', TransporterController::class .'@show')->name('transporters.show');
Route::get('/transporters/{transporter}/edit', TransporterController::class .'@edit')->name('transporters.edit');
Route::put('/transporters/{transporter}', TransporterController::class .'@update')->name('transporters.update');
Route::delete('/transporters/{transporter}', TransporterController::class .'@destroy')->name('transporters.destroy');


Route::get('/clients', ClientController::class .'@index')->name('clients.index');
Route::get('/clients/create', ClientController::class . '@create')->name('clients.create');
Route::post('/clients', ClientController::class .'@store')->name('clients.store');
Route::get('/clients/{client}', ClientController::class .'@show')->name('clients.show');
Route::get('/clients/{client}/edit', ClientController::class .'@edit')->name('clients.edit');
Route::put('/clients/{client}', ClientController::class .'@update')->name('clients.update');
Route::delete('/clients/{client}', ClientController::class .'@destroy')->name('clients.destroy');


Route::get('/trucks', TruckController::class .'@index')->name('trucks.index');
Route::get('/trucks/create', TruckController::class . '@create')->name('trucks.create');
Route::post('/trucks', TruckController::class .'@store')->name('trucks.store');
Route::get('/trucks/{truck}', TruckController::class .'@show')->name('trucks.show');
Route::get('/trucks/{truck}/edit', TruckController::class .'@edit')->name('trucks.edit');
Route::put('/trucks/{truck}', TruckController::class .'@update')->name('trucks.update');
Route::delete('/trucks/{truck}', TruckController::class .'@destroy')->name('trucks.destroy');


Route::get('/drivers', DriverController::class .'@index')->name('drivers.index');
Route::get('/drivers/create', DriverController::class . '@create')->name('drivers.create');
Route::post('/drivers', DriverController::class .'@store')->name('drivers.store');
Route::get('/drivers/{driver}', DriverController::class .'@show')->name('drivers.show');
Route::get('/drivers/{driver}/edit', DriverController::class .'@edit')->name('drivers.edit');
Route::put('/drivers/{driver}', DriverController::class .'@update')->name('drivers.update');
Route::delete('/drivers/{driver}', DriverController::class .'@destroy')->name('drivers.destroy');


Route::get('/bookings', BookingController::class .'@index')->name('bookings.index');
Route::get('/bookings/create', BookingController::class . '@create')->name('bookings.create');
Route::post('/bookings', BookingController::class .'@store')->name('bookings.store');
Route::get('/bookings/{booking}/edit', BookingController::class .'@edit')->name('bookings.edit');
Route::put('/bookings/{booking}', BookingController::class .'@update')->name('bookings.update');
Route::get('/booking/{booking_id}', [BookingController::class, 'show'])->name('bookings.show');


Route::delete('/bookings/{booking}', BookingController::class .'@destroy')->name('bookings.destroy');
Route::get('/get-driver-details/{id}', 'App\Http\Controllers\BookingController@getDriverDetails');

// Route::put('/documents/{id}', [DriverController::class, 'updateDocuments'])->name('documents.update');

Route::put('/documents/{id}', [DriverController::class, 'updateDocuments'])->name('documents.update');


Route::post('/bookings/store-tracking', [BookingController::class, 'storeTracking'])->name('bookings.storeTracking');
Route::post('/bookings/store-document', [BookingController::class, 'storeDocument'])->name('bookings.storeDocument');

Route::get('/invoices', InvoiceController::class .'@index')->name('invoices.index');
Route::put('/invoices/{invoice}', InvoiceController::class .'@update')->name('invoices.update');
Route::get('/get-driver-details/{id}', 'App\Http\Controllers\InvoiceController@getDriverDetails');
// Route::put('/documents/{id}', [InvoiceController::class, 'updateDocuments'])->name('documents.update');
Route::get('invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::post('/invoices', [InvoiceController::class, 'invoiceStore'])->name('invoices.invoiceStore');
Route::post('/invoices/store', [InvoiceController::class, 'documentStore'])->name('invoices.documentStore');

Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

Route::get('/bookingshow/{id}', [BookingController::class, 'show'])->name('bookings.show');



Route::post('/tracking/{id}', [BookingController::class, 'updateTracking'])->name('tracking.updateTracking');
Route::get('/tracking/edit/{id}',[BookingController::class, 'editTracking'])->name('tracking.editTracking');
Route::get('/tracking/{id}/edit', [BookingController::class, 'editTracking'])->name('tracking.edit');
Route::get('/tracking/details/{id}', 'BookingController@getTrackingDetails');
Route::get('/bookings/{id}/edit', 'BookingController@editTracking')->name('bookings.editTracking');
Route::put('/bookings/{id}/update', 'BookingController@updateTracking')->name('bookings.updateTracking');

Route::resource('transactions', TransactionController::class);
Route::resource('user', UserController::class);


Route::get('/reports/booking', [ReportController::class, 'bookingIndex'])->name('reports.bookingIndex');


Route::get('/reports/drivers', [ReportController::class, 'indexDriver'])->name('reports.driverIndex');


Route::get('/reports/tranporters', [ReportController::class, 'indexTranporter'])->name('reports.transporterIndex');


Route::get('/reports/invoices', [ReportController::class, 'indexInvoice'])->name('reports.invoiceIndex');


Route::get('/bookings/{booking_id}', [ReportController::class, 'show'])->name('reports.showBooking');

Route::get('/driver/{booking_id}', [ReportController::class, 'showDriver'])->name('reports.showDriver');

Route::get('/transports/{booking_id}', [ReportController::class, 'showTransporter'])->name('reports.showTransporter');

Route::get('/invoicesreports/{booking_id}', [ReportController::class, 'showInvoice'])->name('reports.showInvoice');


Route::get('/generate-invoicereport', [ReportController::class, 'generateInvoiceReport'])->name('generate.Invoice');


Route::get('/generate-transporterreport', [ReportController::class, 'generateTranporterReport'])->name('generate.transporter');


Route::get('/generate-driverreport', [ReportController::class, 'generateDriverReport'])->name('generate.driverreport');

Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/login');
});
});

Route::get('/get-booking-driver-wise-transporter/{transporter_id}', [TransporterController::class,'getBookingDriverWiseTransporter']);


Auth::routes();

Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');

Route::get('/admin/register',[RegisterController::class,'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register',[RegisterController::class,'createAdmin'])->name('admin.register');


Route::get('/admin/dashboard',function(){
    return view('admin');
})->middleware('auth:admin');