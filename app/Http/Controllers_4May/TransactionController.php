<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Route;
use App\Models\City;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Border;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $city_list = City::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        // $bookings = Booking::where('created_by', Auth::user()->creatorId())->get();
        $bookings = Booking::with(['transactions' => function ($query) {
            $query->latest()->limit(1);
        }, 'invoice'])->get();
        $transactions = Transaction::where('created_by', Auth::user()->creatorId())->get();
        // dd($bookings);
        return view('transactions.index', compact('customers', 'routes', 'clients', 'drivers', 'bookings', 'city_list', 'transactions'));
    }



public function store(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'transaction_id' => 'required|string',
        'booking_id' => 'required|string',
        'date' => 'required|date',
        'route_name' => 'required|string',
        'origin' => 'required|string',
        'destination' => 'required|string',
        'driver_id' => 'required|array',
        'driver_id.*' => 'required|numeric',
        'semi_buying_amount.*' => 'required|numeric',
        'semi_border_charges.*' => 'required|numeric',
        'semi_waiting_amount.*' => 'required|numeric',
        'semi_total_booking_amount.*' => 'required|numeric',
        'paid_amount.*' => 'required|numeric',
        'balance_amount.*' => 'required|numeric',
        'amount.*' => 'required|numeric',
        'mode' => 'required|string',
    ]);

    // Convert other array fields from JSON string to array and convert integer values to decimal
    $arrayFields = ['semi_buying_amount', 'semi_border_charges', 'semi_waiting_amount', 'semi_total_booking_amount', 'balance_amount'];
    foreach ($arrayFields as $field) {
        $validatedData[$field] = array_map(function ($value) {
            return number_format($value, 2); // Convert integer to decimal with 2 decimal places
        }, $validatedData[$field]);
    }

    // Convert array values to comma-separated strings
    $validatedData['driver_id'] = implode(',', $validatedData['driver_id']);
    $validatedData['semi_buying_amount'] = implode(',', $validatedData['semi_buying_amount']);
    $validatedData['semi_border_charges'] = implode(',', $validatedData['semi_border_charges']);
    $validatedData['semi_waiting_amount'] = implode(',', $validatedData['semi_waiting_amount']);
    $validatedData['semi_total_booking_amount'] = implode(',', $validatedData['semi_total_booking_amount']);
    $validatedData['paid_amount'] = implode(',', $validatedData['paid_amount']);
    $validatedData['balance_amount'] = implode(',', $validatedData['balance_amount']);
    $validatedData['amount'] = implode(',', $validatedData['amount']);

    // Perform element-wise addition
    $validatedPaidAmount = explode(',', $validatedData['paid_amount']);
    $validatedAmount = explode(',', $validatedData['amount']);

    // Check if arrays have the same length
    $countPaidAmount = count($validatedPaidAmount);
    $countAmount = count($validatedAmount);

    if ($countPaidAmount !== $countAmount) {
        // Handle the mismatch gracefully, such as logging an error or returning a response
        return response()->json(['error' => 'Paid amount and amount arrays have different lengths'], 400);
    }

    // Perform element-wise addition only if the arrays have the same length
    $summedAmounts = [];
    for ($i = 0; $i < $countPaidAmount; $i++) {
        $summedAmounts[] = (float) $validatedPaidAmount[$i] + (float) $validatedAmount[$i];
    }

    $validatedData['summedAmounts'] = implode(',', $summedAmounts);
// dd($validatedData['summedAmounts']);
    // Create a single transaction entry
    $transaction = new Transaction();
    $transaction->created_by = Auth::user()->creatorId();
    $transaction->transaction_id = $validatedData['transaction_id'];
    $transaction->booking_id = $validatedData['booking_id'];
    $transaction->transaction_date = $validatedData['date'];
    $transaction->driver_id = $validatedData['driver_id'];
    $transaction->semi_buying_amount = $validatedData['semi_buying_amount'];
    $transaction->semi_border_charges = $validatedData['semi_border_charges'];
    $transaction->semi_waiting_amount = $validatedData['semi_waiting_amount'];
    $transaction->semi_total_booking_amount = $validatedData['semi_total_booking_amount'];
    $transaction->paid_amount = $validatedData['summedAmounts'];
    $transaction->amount = $validatedData['amount'];
    $transaction->payment_mode = $validatedData['mode'];
    $transaction->reference_no = $validatedData['cheque_number'] ?? 'NA';
    // Add other fields here similarly

    // Save the transaction to the database
    $transaction->save();

    // Redirect to a success page or return a success response
    return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully.');
}


    /**
     * Display the specified resource.
     */
    public function update(Request $request, string $id)
    {
        // Find the route by its ID
        $booking = Booking::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([

            'booking_id' => 'required|string',
            'date' => 'required|string',
            'customer_id' => 'required',
            'receiver_id' => 'required|string',
            'driver_id' => 'nullable|string',
            'route_id' => 'required|string',
            'buying_amount' => 'required|string',
            'border_charges' => 'required|string',
            'total_booking_amount' => 'required|string',
            'semi_buying_amount' => 'required|string',
            'semi_border_charges' => 'required|string',
            'semi_total_booking_amount' => 'required|string',
        ]);

        // Update the route with the validated data
        $booking->update($validatedData);

        // Return a response indicating success
         return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
}

    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
    {
      $booking = Booking::find($id);
      $booking->delete();
      return redirect()->route('bookings.index')
        ->with('success', 'Booking deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function create()
    {
        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();

        return view('bookings.create', compact('customers', 'routes', 'clients', 'drivers', 'borders'));
    }

  public function show($id)
  {
    $booking = Booking::find($id);
    return view('bookings.show', compact('booking'));
  }

  public function edit($id)
  {
    $booking = Booking::find($id);
    $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
    $routes = Route::where('created_by', Auth::user()->creatorId())->get();
    $clients = Client::where('created_by', Auth::user()->creatorId())->get();
    $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
    $borders = Border::where('created_by', Auth::user()->creatorId())->get();
    // dd($booking);
    return view('bookings.edit', compact('booking', 'customers', 'routes', 'clients', 'drivers', 'borders'));
  }

  public function getDriverDetails($id) {

    $driver = Driver::find($id);



    if($driver) {
        return response()->json(['success' => true, 'driver' => $driver]);
    } else {
        return response()->json(['success' => false]);
    }
}


}