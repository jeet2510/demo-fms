<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Driver;
use App\Models\Truck;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;




class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $drivers = Driver::where('created_by', Auth::user()->creatorId())->latest()->get();
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
            'driver_name' => 'required|string|unique:drivers,driver_name',
            'email' => '',
            'phone_number' => 'required|string',
            'whatsapp_number' => 'nullable|string',
            'address_1' => '',
            'address_2' => '',
            'country' => '',
            'state' => '',
            'city' => '',
            'truck_type_id' => 'required|integer',
            'truck_number' => 'required|string',
            'truck_expiry_date' => 'required|date',
            'id_card_number' => 'required|string',
            'id_card_expiry_date' => 'required|date',
            'driving_license_number' => 'required|string',
            'driving_license_expiry_date' => 'required|date',
            'passport_number' => 'required|string',
            'passport_expiry_date' => 'required|date',

        ];

        // Validate request
        $request->validate($rules);

        // dd($request);


    // Handle file uploads and store them

    // dd($request);
    if ($request->hasFile('passport')) {
        $passportExtension = $request->file('passport')->getClientOriginalExtension();
        $passportName = 'passport_' . Str::random(10) . '_' . time() . '.' . $passportExtension;
        $request->file('passport')->move(public_path('uploads'), $passportName);
        $passportPath = 'uploads/' . $passportName;
    }

    if ($request->hasFile('id_card')) {
        $idCardExtension = $request->file('id_card')->getClientOriginalExtension();
        $idCardName = 'id_card_' . Str::random(10) . '_' . time() . '.' . $idCardExtension;
        $request->file('id_card')->move(public_path('uploads'), $idCardName);
        $idCardPath = 'uploads/' . $idCardName;
    }

    if ($request->hasFile('driving_license')) {
        $drivingLicenseExtension = $request->file('driving_license')->getClientOriginalExtension();
        $drivingLicenseName = 'driving_license_' . Str::random(10) . '_' . time() . '.' . $drivingLicenseExtension;
        $request->file('driving_license')->move(public_path('uploads'), $drivingLicenseName);
        $drivingLicensePath = 'uploads/' . $drivingLicenseName;
    }

    if ($request->hasFile('truck_document')) {
        $truckDocumentExtension = $request->file('truck_document')->getClientOriginalExtension();
        $truckDocumentName = 'truck_document_' . Str::random(10) . '_' . time() . '.' . $truckDocumentExtension;
        $request->file('truck_document')->move(public_path('uploads'), $truckDocumentName);
        $truckDocumentPath = 'uploads/' . $truckDocumentName;
    }

    if ($request->hasFile('driver_all_documents')) {
        $driveAllDocExtension = $request->file('driver_all_documents')->getClientOriginalExtension();
        $driverAllDocName = 'driver_all_documents_' . Str::random(10) . '_' . time() . '.' . $driveAllDocExtension;
        $request->file('driver_all_documents')->move(public_path('uploads'), $driverAllDocName);
        $driverAllDocumentPath = 'uploads/' . $driverAllDocName;
    }
    $passportPath = $passportPath ?? '';
    $idCardPath = $idCardPath ?? '';
    $drivingLicensePath = $drivingLicensePath ?? '';
    $truckDocumentPath = $truckDocumentPath ?? '';
    $driverAllDocumentPath = $driverAllDocumentPath  ?? '';



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
        $driver->all_documents = $driverAllDocumentPath;

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
            'driver_name' => 'required|string|unique:drivers,driver_name,' . $id,
            'email' => '',
            'phone_number' => 'string',
            'whatsapp_number' => 'nullable|string',
            'address_1' => '',
            'address_2' => '',
            'country' => '',
            'state' => '',
            'city' => '',
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
            $passportExtension = $request->file('passport')->getClientOriginalExtension();
            $passportName = 'passport_' . Str::random(10) . '_' . time() . '.' . $passportExtension;
            $request->file('passport')->move(public_path('uploads'), $passportName);
            $passportPath = 'uploads/' . $passportName;
        }

        if ($request->hasFile('id_card')) {
            $idCardExtension = $request->file('id_card')->getClientOriginalExtension();
            $idCardName = 'id_card_' . Str::random(10) . '_' . time() . '.' . $idCardExtension;
            $request->file('id_card')->move(public_path('uploads'), $idCardName);
            $idCardPath = 'uploads/' . $idCardName;
        }

        if ($request->hasFile('driving_license')) {
            $drivingLicenseExtension = $request->file('driving_license')->getClientOriginalExtension();
            $drivingLicenseName = 'driving_license_' . Str::random(10) . '_' . time() . '.' . $drivingLicenseExtension;
            $request->file('driving_license')->move(public_path('uploads'), $drivingLicenseName);
            $drivingLicensePath = 'uploads/' . $drivingLicenseName;
        }

        if ($request->hasFile('truck_document')) {
            $truckDocumentExtension = $request->file('truck_document')->getClientOriginalExtension();
            $truckDocumentName = 'truck_document_' . Str::random(10) . '_' . time() . '.' . $truckDocumentExtension;
            $request->file('truck_document')->move(public_path('uploads'), $truckDocumentName);
            $truckDocumentPath = 'uploads/' . $truckDocumentName;
        }
        if ($request->hasFile('all_documents')) {
            $driveAllDocExtension = $request->file('all_documents')->getClientOriginalExtension();
            $driverAllDocName = 'driver_all_documents_' . Str::random(10) . '_' . time() . '.' . $driveAllDocExtension;
            $request->file('all_documents')->move(public_path('uploads'), $driverAllDocName);
            $driverAllDocumentPath = 'uploads/' . $driverAllDocName;
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
        if(isset($passportPath))
        {
            $driver->passport = $passportPath;
        }
        if(isset($idCardPath))
        {
            $driver->id_card = $idCardPath;
        }
        if(isset($drivingLicensePath))
        {
            $driver->driving_license = $drivingLicensePath;
        }
        if(isset($truckDocumentPath))
        {
            $driver->truck_document = $truckDocumentPath;
        }
        if(isset($driverAllDocumentPath))
        {
            $driver->all_documents = $driverAllDocumentPath;
        }

        $driver->save();
        return redirect()->route('drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    private function deleteOldFiles($driver, $request)
    {
        $filesToDelete = [];
        // Check if new files are uploaded and prepare list of files to delete
        if ($request->hasFile('passport')) {
            $filesToDelete[] = $driver->passport;
        }
        if ($request->hasFile('id_card')) {
            $filesToDelete[] = $driver->id_card;
        }
        if ($request->hasFile('driving_license')) {
            $filesToDelete[] = $driver->driving_license;
        }
        if ($request->hasFile('truck_document')) {
            $filesToDelete[] = $driver->truck_document;
        }
        // Delete files from storage
        foreach ($filesToDelete as $file) {
            $filePath = public_path($file);
            if ($file && file_exists($filePath)) {
                unlink($filePath);
            }
        }
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