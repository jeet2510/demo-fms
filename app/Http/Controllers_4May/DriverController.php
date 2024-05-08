<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Driver;
use App\Models\Truck;

use Illuminate\Support\Facades\Auth;




class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();
      $trucks = Truck::where('created_by', Auth::user()->creatorId())->get();

      return view('drivers.index', compact('drivers','trucks' ));
    }
    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    // Define validation rules
    $rules = [
        'driver_name' => 'required|string',
        'email' => 'required|email',
        'phone_number' => 'required|string',
        'whatsapp_number' => 'nullable|string',
        'address_1' => 'required|string',
        'address_2' => 'nullable|string',
        'country' => 'required|string',
        'state' => 'required|string',
        'city' => 'required|string',
        'truck_type_id' => 'required|integer',
        'truck_number' => 'required|string',
        'truck_expiry_date' => 'required|date',
        'id_card_number' => 'required|string',
        'id_card_expiry_date' => 'required|date',
        'driving_license_number' => 'required|string',
        'driving_license_expiry_date' => 'required|date',
        'passport_number' => 'required|string',
        'passport_expiry_date' => 'required|date',
        'passport' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        'id_card' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        'driving_license' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        'truck_document' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
      ];

    // Validate request
    $request->validate($rules);

    // dd($request);


   // Handle file uploads and store them
   $passportPath = $passportPath ?? '';
   $idCardPath = $idCardPath ?? '';
   $drivingLicensePath = $drivingLicensePath ?? '';
   $truckDocumentPath = $truckDocumentPath ?? '';

    if ($request->hasFile('passport')) {
        $passportPath = $request->file('passport')->store('documents');
    }

    if ($request->hasFile('id_card')) {
        $idCardPath = $request->file('id_card')->store('documents');
    }

    if ($request->hasFile('driving_license')) {
        $drivingLicensePath = $request->file('driving_license')->store('documents');
    }

    if ($request->hasFile('truck_document')) {
        $truckDocumentPath = $request->file('truck_document')->store('documents');
    }


    // Create a new driver instance
    $driver = new Driver();
    $driver->driver_name = $request->input('driver_name');
    $driver->email = $request->input('email');
    $driver->phone_number = $request->input('phone_number');
    $driver->whatsapp_number = $request->input('whatsapp_number');
    $driver->address_1 = $request->input('address_1');
    $driver->address_2 = $request->input('address_2');
    $driver->country = $request->input('country');
    $driver->state = $request->input('state');
    $driver->city = $request->input('city');
    $driver->truck_type_id = $request->input('truck_type_id');
    $driver->truck_number = $request->input('truck_number');
    $driver->truck_expiry_date = $request->input('truck_expiry_date');
    $driver->id_card_number = $request->input('id_card_number');
    $driver->id_card_expiry_date = $request->input('id_card_expiry_date');
    $driver->driving_license_number = $request->input('driving_license_number');
    $driver->driving_license_expiry_date = $request->input('driving_license_expiry_date');
    $driver->passport_number = $request->input('passport_number');
    $driver->passport_expiry_date = $request->input('passport_expiry_date');
    $driver->passport = $passportPath;
    $driver->id_card = $idCardPath;
    $driver->driving_license = $drivingLicensePath;
    $driver->truck_document = $truckDocumentPath;

    $driver->created_by = Auth::user()->creatorId();

    // Save the driver to the database
    $driver->save();

    // Redirect or return response as needed
    return redirect()->route('drivers.index')
        ->with('success', 'Driver created successfully.');
}



public function update(Request $request, $id)
{


    $rules = [
        'driver_name' => 'string',
        'email' => 'email',
        'phone_number' => 'string',
        'whatsapp_number' => 'nullable|string',
        'address_1' => 'string',
        'address_2' => 'nullable|string',
        'country' => 'string',
        'state' => 'string',
        'city' => 'string',
        'truck_type_id' => 'integer',
        'truck_number' => 'string',
        'truck_expiry_date' => 'date',
        'id_card_number' => 'string',
        'id_card_expiry_date' => 'date',
        'driving_license_number' => 'string',
        'driving_license_expiry_date' => 'date',
        'passport_number' => 'string',
        'passport_expiry_date' => 'date',
        'passport' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
        'id_card' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
        'driving_license' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
        'truck_document' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
    ];

    // Validate request
    $request->validate($rules);

    // Find the driver by ID
    $driver = Driver::findOrFail($id);

    // Handle file uploads and update paths if files are present

    if ($request->hasFile('passport')) {
        $driver->passport = $request->file('passport')->store('documents');
    }

    if ($request->hasFile('id_card')) {
        $driver->id_card = $request->file('id_card')->store('documents');
    }

    if ($request->hasFile('driving_license')) {
        $driver->driving_license = $request->file('driving_license')->store('documents');
    }

    if ($request->hasFile('truck_document')) {
        $driver->truck_document = $request->file('truck_document')->store('documents');
    }

    // Update driver information
    $driver->driver_name = $request->input('driver_name');
    $driver->email = $request->input('email');
    $driver->phone_number = $request->input('phone_number');
    $driver->whatsapp_number = $request->input('whatsapp_number');
    $driver->address_1 = $request->input('address_1');
    $driver->address_2 = $request->input('address_2');
    $driver->country = $request->input('country');
    $driver->state = $request->input('state');
    $driver->city = $request->input('city');
    $driver->truck_type_id = $request->input('truck_type_id');
    $driver->truck_number = $request->input('truck_number');
    $driver->truck_expiry_date = $request->input('truck_expiry_date');
    $driver->id_card_number = $request->input('id_card_number');
    $driver->id_card_expiry_date = $request->input('id_card_expiry_date');
    $driver->driving_license_number = $request->input('driving_license_number');
    $driver->driving_license_expiry_date = $request->input('driving_license_expiry_date');
    $driver->passport_number = $request->input('passport_number');
    $driver->passport_expiry_date = $request->input('passport_expiry_date');

    // Save the updated driver to the database
    $driver->save();

    // Redirect or return response as needed
    return redirect()->route('drivers.index')
        ->with('success', 'Driver updated successfully.');
}

    /**
     * Display the specified resource.
     */
    public function destroy($id)
  {
    $driver = Driver::find($id);
    $driver->delete();
    return redirect()->route('drivers.index')
      ->with('success', 'Driver deleted successfully');
  }

    /**
     * Update the specified resource in storage.
     */
    public function create()
  {
    $drivers = Driver::where('created_by', Auth::user()->creatorId())->get();

    return view('drivers.create', compact('drivers'));
  }

    /**
     * Remove the specified resource from storage.
     */
    public function show($id)
  {
    $driver = Driver::find($id);
    return view('drivers.show', compact('driver'));
  }

  public function edit($id)
  {
    $driver = Driver::find($id);
    $trucks = Truck::where('created_by', Auth::user()->creatorId())->get();

    return view('drivers.edit', compact('driver', 'trucks'));
  }



public function updateDocuments(Request $request, $id)
{
    $rules = [
        'id_card_number' => 'string',
        'id_card_expiry_date' => 'date',
        'driving_license_number' => 'string',
        'driving_license_expiry_date' => 'date',
        'passport_number' => 'string',
        'passport_expiry_date' => 'date',
        'passport' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
        'id_card' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
        'driving_license' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
    ];

    //  dd($rules);
    $request->validate($rules);

    $driver = Driver::findOrFail($id);

    if ($request->hasFile('passport')) {
        $driver->passport = $request->file('passport')->store('documents');
    }

    if ($request->hasFile('id_card')) {
        $driver->id_card = $request->file('id_card')->store('documents');
    }

    // dd($request);

    if ($request->hasFile('driving_license')) {
        $driver->driving_license = $request->file('driving_license')->store('documents');
    }

    if ($request->has('id_card_number')) {
        $driver->id_card_number = $request->input('id_card_number');
    }

    if ($request->has('passport_number')) {
        $driver->passport_number = $request->input('passport_number');
    }

    if ($request->has('driving_license_number')) {
        $driver->driving_license_number = $request->input('driving_license_number');
    }

    if ($request->has('id_card_expiry_date')) {
        $driver->id_card_expiry_date = $request->input('id_card_expiry_date');
    }

    if ($request->has('passport_expiry_date')) {
        $driver->passport_expiry_date = $request->input('passport_expiry_date');
    }

    if ($request->has('driving_license_expiry_date')) {
        $driver->driving_license_expiry_date = $request->input('driving_license_expiry_date');
    }

    $driver->save();


     return redirect()->route('bookings.create')
        ->with('success', 'Document updated successfully.');
}
}
