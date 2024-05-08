<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $clients = Client::where('created_by', Auth::user()->creatorId())->get();
      return view('clients.index', compact('clients'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'company_name' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Create a new Customer instance
        $clients = new Client();
        $clients->company_name = $request->company_name;
        $clients->contact_person = $request->contact_person;
        $clients->email = $request->email;
        $clients->phone = $request->phone;
        $clients->address = $request->address;
        $clients->city = $request->city;
        $clients->state = $request->state;
        $clients->pin_code = $request->pin_code;
        $clients->country = $request->country;
        $clients->created_by = Auth::user()->creatorId();


        // Save the customer
        $clients->save();

        // Return a response
        return redirect()->route('clients.index')
        ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, string $id)
    {
        // Find the route by its ID
        $clients = Client::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([

            'company_name' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Update the route with the validated data
        $clients->update($validatedData);

        // Return a response indicating success
         return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
}

    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
  {
    $client = Client::find($id);
    $client->delete();
    return redirect()->route('clients.index')
      ->with('success', 'client deleted successfully');
  }

  public function create()
  {
    return view('clients.create');
  }

  public function show($id)
  {
    $client = Client::find($id);
    return view('clients.show', compact('client'));
  }

  public function edit($id)
  {
    $client = Client::find($id);
    return view('clients.edit', compact('client'));
  }
}
