<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
  {
    $customers = Customer::where('created_by', Auth::user()->creatorId())
    ->orderBy('created_at', 'desc')
    ->get();
    return view('customers.index', compact('customers'));
  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'company_name' => 'required|string|unique:customers,company_name',
            'contact_person' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string',
            'tax_register_number' => 'nullable|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Create a new Customer instance
        $customer = new Customer();
        $customer->company_name = $request->company_name;
        $customer->contact_person = $request->contact_person;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->tax_register_number = $request->tax_register_number;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->pin_code = $request->pin_code;
        $customer->country = $request->country;
        $customer->created_by = Auth::user()->creatorId();


        // Save the customer
        $customer->save();

        // Return a response
        return redirect()->route('customers.index')
        ->with('success', 'Customer created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the route by its ID
        $customer = Customer::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'company_name' => ['required', 'string', Rule::unique('customers')->ignore($customer->id)],
            'contact_person' => 'required|string',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone' => 'required|string',
            'tax_register_number' => 'nullable|string',
            'address' => '',
            'city' => '',
            'state' => '',
            'pin_code' => '',
            'country' => '',
        ]);

        // Update the route with the validated data
        $customer->update($validatedData);

        // Return a response indicating success
         return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
  {
    $customer = Customer::find($id);
    $customer->delete();
    return redirect()->route('customers.index')
      ->with('success', 'Customer deleted successfully');
  }


  public function create()
  {
    return view('customers.create');
  }

  public function show($id)
  {
    $customer = Customer::find($id);
    return view('customers.show', compact('customer'));
  }

  public function edit($id)
  {
    $customer = Customer::find($id);
    return view('customers.edit', compact('customer'));
  }
}