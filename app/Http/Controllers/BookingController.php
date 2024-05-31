<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Border;
use App\Models\Client;
use App\Models\Customer;
use App\Models\Transporter;
use Illuminate\Support\Str;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Truck;
use App\Models\City;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use App\Models\Transaction;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $transporters = Transporter::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        if($drivers == null || $drivers->count() == 0){
            $trucks = Truck::where('created_by', Auth::user()->creatorId())->get();
            if($trucks == null || $trucks->count() == 0){
                return redirect()->route('trucks.index')->with('error', 'Please Add Driver or Truck');
            }
            return redirect()->route('drivers.index')->with('error', 'Please Add Driver');
        }
        // $bookings = Booking::where('created_by', Auth::user()->creatorId())->with('invoice')->get();
        $bookings = Booking::where('created_by', Auth::user()->creatorId())
                    ->doesnthave('invoice');
        if ($dateFrom !== null && $dateTo !== null) {
            $bookings->whereBetween('date', [$dateFrom, $dateTo]);
        }
        $bookings = $bookings->latest()->paginate(25);
        $trackings = Tracking::where('created_by', Auth::user()->creatorId())->get();
        $transactions = Transaction::where('created_by', Auth::user()->creatorId())->get();


        return view('bookings.index', compact('customers', 'transporters','routes', 'clients', 'drivers', 'bookings', 'trackings', 'transactions'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $new_booking_id = 'BOOK-' . $request->booking_id;

        $validatedData = $request->validate([
            'booking_id' => 'required|string',
            'date' => 'required|string',
            'customer_id' => 'required',
            'transporter_id' => 'required',
            'receiver_id' => 'required|string',
            'driver_id' => 'nullable|array',
            'route_id' => 'required|string',
            'buying_amount' => 'required|string',
            'border_charges' => 'required|string',
            'total_booking_amount' => 'required|string',
            'semi_buying_amount.*' => 'required|numeric',
            'semi_border_charges.*' => 'required|numeric',
            'semi_total_booking_amount.*' => 'required|numeric',
            'origin_city' => 'required',
            'destination_city' => 'required',
        ]);


        $seprate_border_charges = json_encode($request->seprate_border_charge ?? NULL);
        $booking = new Booking();
        $booking->booking_id = $new_booking_id;
        $booking->date = $validatedData['date'];
        $booking->customer_id = $validatedData['customer_id'];
         $booking->transporter_id = json_encode($validatedData['transporter_id']);
         $booking->receiver_id = $validatedData['receiver_id'];
        $booking->driver_id = implode(',', $validatedData['driver_id']);
        $booking->route_id = $validatedData['route_id'];
        $booking->origin_city = $validatedData['origin_city'];
        $booking->destination_city = $validatedData['destination_city'];
        $booking->buying_amount = $validatedData['buying_amount'];
        $booking->border_charges = $validatedData['border_charges'];
        $booking->seprate_border_charge = $seprate_border_charges;
        $booking->total_booking_amount = $validatedData['total_booking_amount'];
        $booking->semi_buying_amount = json_encode($validatedData['semi_buying_amount']);
        $booking->semi_border_charges = json_encode($validatedData['semi_border_charges']);
        $booking->semi_total_booking_amount = json_encode($validatedData['semi_total_booking_amount']);
        $booking->created_by = Auth::user()->creatorId();

		$transporter = Transporter::where('created_by', Auth::user()->creatorId())->where('id',$request->transporter_id)->first();
        if($transporter==null)
		{
			 $transporter = new transporter();
        $transporter->transporter_name = $request->transporter_id;
         $transporter->save();
		 $booking->transporter_id =$transporter->id;
		}
        $booking->save();

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function checkBookingId(Request $request)
    {
        $bookingId = 'BOOK-'.$request->input('booking_id');

        if (Booking::where('booking_id', $bookingId)->exists()) {
            return response()->json(['exists' => true]);
        }

        return response()->json(['exists' => false]);
    }
    public function update(Request $request, string $id)
    {

        // dd($request, $id);

        $booking = Booking::findOrFail($id);
// dd('ok');
        $validatedData = $request->validate([
            'buying_amount' => 'required|string',
            'transporter_id.*' => 'required',
            'border_charges' => 'required|string',
            'total_booking_amount' => 'required|string',
            'semi_buying_amount.*' => 'required|numeric',
            'semi_border_charges.*' => 'required|numeric',
            'semi_total_booking_amount.*' => 'required|numeric',
        ]);

        $validatedData['seprate_border_charge'] = json_encode($request->seprate_border_charge ?? NULL);

        $booking->update($validatedData);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete(); // Soft delete the booking
            return redirect()->route('bookings.index')
                ->with('success', 'Booking deleted successfully');
        } else {
            return redirect()->route('bookings.index')
                ->with('error', 'Booking not found');
        }
    }

    public function create()
    {
        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $transporters = Transporter::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();
        $cities = City::where('created_by', Auth::user()->creatorId())->get();
        return view('bookings.create', compact('customers', 'transporters','routes', 'clients', 'drivers', 'borders', 'cities'));
    }

    public function edit($id)
    {
        $booking = Booking::find($id);
        $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $transporters = Transporter::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();

        return view('bookings.edit', compact('booking', 'customers','transporters', 'routes', 'clients', 'drivers', 'borders', 'transactions'));
    }

    public function getDriverDetails($id)
    {

        $driver = Driver::find($id);
        if ($driver) {
            return response()->json(['success' => true, 'driver' => $driver]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function storeTracking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|max:255',
            'tracking_status' => 'required',
            'tracking_title' => 'required',
            'tracking_remark' => 'required',
            'tracking_date' => 'required',

        ]);

        $tracking = new Tracking();

        $tracking->booking_id = $request->booking_id;
        $tracking->tracking_status = $request->tracking_status;
        $tracking->tracking_title = $request->tracking_title;
        $tracking->tracking_remark = $request->tracking_remark;
        $tracking->tracking_date = $request->tracking_date;

        $tracking->created_by = Auth::user()->creatorId();

        $tracking->save();

        return redirect()->route('bookings.index')
            ->with('success', 'Tracking created successfully.');
    }

    public function indexdocument()
    {
        $bookings = Booking::where('created_by', Auth::user()->creatorId())->get();
        return view('bookings.bookingDocument', compact('customers', 'routes', 'clients', 'drivers', 'bookings', 'trackings'));
    }

    public function storeDocument(Request $request)
    {

        $validatedData = $request->validate([
            'booking_document' => 'required',
            'booking_id' => 'required',
        ]);

        $booking = Booking::where('booking_id', $validatedData['booking_id'])->first();
        $handOverFileName = time() . '_' . $request->file('booking_document')->getClientOriginalName();
        $request->file('booking_document')->move(public_path('uploads'), $handOverFileName);
        $booking->booking_document = '/uploads/' . $handOverFileName;
        $booking->update();

        return redirect()->route('bookings.index')->with('success', 'Document created successfully.');
    }


    public function show($id)
    {
        if (Str::contains($id, 'BOOK-')) {
            $booking = Booking::where('booking_id', $id)->first();
        } else {
            $booking = Booking::where('id', $id)->first();
        }
        $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();
        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $transporters = Transporter::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();
        return view('bookings.show',  compact('booking', 'customers','transporters', 'routes', 'clients', 'drivers', 'borders', 'transactions'));
    }


}
