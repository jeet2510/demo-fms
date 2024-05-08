<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transporter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
  {
    $transporters = transporter::where('created_by', Auth::user()->creatorId())->latest()->get();
    return view('transporters.index', compact('transporters'));
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'transporter_name' => 'required|string|unique:transporters,transporter_name',
            'contact_person' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'tax_register_number' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Create a new transporter instance
        $transporter = new Transporter();
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

    public function update(Request $request, string $id)
    {
        // Find the transporter by its ID
        $transporter = Transporter::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'transporter_name' => ['required', 'string', Rule::unique('transporters')->ignore($transporter->id)],
            'contact_person' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'tax_register_number' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Update the transporter with the validated data
        $transporter->update($validatedData);

        // Return a response indicating success
        return redirect()->route('transporters.index')->with('success', 'Transporter updated successfully.');
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