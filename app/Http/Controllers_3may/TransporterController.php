<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transporter;
use Illuminate\Support\Facades\Auth;



class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
  {
    $transporters = transporter::where('created_by', Auth::user()->creatorId())->get();
    return view('transporters.index', compact('transporters'));
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'transporter_name' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email|unique:transporters,email',
            'phone' => 'required|string',
            'tax_register_number' => 'nullable|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Create a new transporter instance
        $transporter = new transporter();
        $transporter->transporter_name = $request->transporter_name;
        $transporter->contact_person = $request->contact_person;
        $transporter->email = $request->email;
        $transporter->phone = $request->phone;
        $transporter->tax_register_number = $request->tax_register_number;
        $transporter->address = $request->address;
        $transporter->city = $request->city;
        $transporter->state = $request->state;
        $transporter->pin_code = $request->pin_code;
        $transporter->country = $request->country;
        $transporter->created_by = Auth::user()->creatorId();


        // Save the transporter
        $transporter->save();

        // Return a response
        return redirect()->route('transporters.index')
        ->with('success', 'transporter created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the route by its ID
        $transporter = transporter::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([

            'transporter_name' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'tax_register_number' => 'nullable|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Update the route with the validated data
        $transporter->update($validatedData);

        // Return a response indicating success
         return redirect()->route('transporters.index')->with('success', 'transporter updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
  {
    $transporter = transporter::find($id);
    $transporter->delete();
    return redirect()->route('transporters.index')
      ->with('success', 'transporter deleted successfully');
  }


  public function create()
  {
    return view('transporters.create');
  }

  public function show($id)
  {
    $transporter = transporter::find($id);
    return view('transporters.show', compact('transporter'));
  }

  public function edit($id)
  {
    $transporter = transporter::find($id);
    return view('transporters.edit', compact('transporter'));
  }
}
