<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Border;
use App\Models\Client;
use App\Models\Customer;
use App\Models\Transporter;
use App\Models\Document;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class InvoiceController extends Controller
{
    public function invoiceStore(Request $request)
    {

        $driver_ids = Booking::where('booking_id', $request->booking_id)->value('driver_id');

        $validatedData = $request->validate([
            'booking_id' => 'required|string',
            'date' => 'required|string',
            'customer_id' => 'required',
            'receiver_id' => 'required|string',
            'driver_id' => 'nullable|array',
            'route_id' => 'required|string',
            'waiting_amount' => 'required|string',
            'buying_amount' => 'required|string',
            'border_charges' => 'required|string',
            'total_booking_amount' => 'required|string',
            'hand_over.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf',
            'border_receipt.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf',
            'semi_buying_amount.*' => 'required|numeric',
            'semi_waiting_amount.*' => 'required|numeric',
            'semi_border_charges.*' => 'required|numeric',
            'semi_total_booking_amount.*' => 'required|numeric',
        ]);
        $seprate_border_charges = json_encode($request->seprate_border_charge ?? NULL);

        $handOverIndex = 1;
        foreach ($request->file('hand_over') as $file) {
            $handOverFileName = time() . '_hand_over_' . $validatedData['booking_id'] . '_' . $handOverIndex . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $handOverFileName);

            $document = new Document();
            $document->hand_over = '/uploads/' . $handOverFileName;
            $document->booking_id = $validatedData['booking_id'];
            $document->save();

            $handOverIndex++;
        }

        $borderReceiptIndex = 1;
        foreach ($request->file('border_receipt') as $file) {
            $borderReceiptFileName = time() . '_border_receipt_' . $validatedData['booking_id'] . '_' . $borderReceiptIndex . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $borderReceiptFileName);

            $document = new Document();
            $document->border_receipt = '/uploads/' . $borderReceiptFileName;
            $document->booking_id = $validatedData['booking_id'];
            $document->save();

            $borderReceiptIndex++;
        }

        $invoice = new Invoice();
        $invoice->booking_id = $validatedData['booking_id'];
        $invoice->date = $validatedData['date'];
        $invoice->customer_id = $validatedData['customer_id'];
        $invoice->receiver_id = $validatedData['receiver_id'];
        $invoice->driver_id = json_encode($driver_ids);
        $invoice->route_id = $validatedData['route_id'];
        $invoice->seprate_border_charge = $seprate_border_charges;
        $invoice->waiting_amount = $validatedData['waiting_amount'];
        $invoice->buying_amount = $validatedData['buying_amount'];
        $invoice->border_charges = $validatedData['border_charges'];
        $invoice->total_booking_amount = $validatedData['total_booking_amount'];
        $invoice->semi_buying_amount = json_encode($validatedData['semi_buying_amount']);
        $invoice->semi_waiting_amount = json_encode($validatedData['semi_waiting_amount']);
        $invoice->semi_border_charges = json_encode($validatedData['semi_border_charges']);
        $invoice->semi_total_booking_amount = json_encode($validatedData['semi_total_booking_amount']);
        $invoice->created_by = Auth::user()->creatorId();
        $invoice->save();

        return redirect()->route('bookings.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $booking = Booking::find($id);
        $customers = Customer::where('created_by', Auth::user()->creatorId())->get();
        $transporters = Transporter::where('created_by', Auth::user()->creatorId())->get();
        $routes = Route::where('created_by', Auth::user()->creatorId())->get();
        $clients = Client::where('created_by', Auth::user()->creatorId())->get();
        $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();
        $transactions = Transaction::where('created_by', Auth::user()->creatorId())->get();

        return view('invoices.edit', compact('booking', 'customers','transporters', 'routes', 'clients', 'drivers', 'borders', 'transactions'));
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

    public function show($id)
    {
        $invoice = Invoice::where('booking_id', $id)->with('document')->first();
        $booking = Booking::where('booking_id', $id)->with('transporter')->first();
        $borders = Border::where('created_by', Auth::user()->creatorId())->get();
        $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

        return view('invoices.show', compact('invoice', 'transactions', 'borders', 'booking'));
    }


}