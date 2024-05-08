<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use Illuminate\Support\Facades\Auth;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $trucks = Truck::where('created_by', Auth::user()->creatorId())->get();
      return view('trucks.index', compact('trucks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([

            'truck_type' => 'required|string',
           'capacity' => '',
        ]);

        // Create a new Customer instance
        $trucks = new Truck();
        $trucks->truck_type = $request->truck_type;
        $trucks->number = $request->number;
        $trucks->capacity = $request->capacity;
        $trucks->created_by = Auth::user()->creatorId();


        // Save the customer
        $trucks->save();

        // Return a response
        return redirect()->route('trucks.index')
        ->with('success', 'Truck created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, string $id)
    {
        // Find the route by its ID
        $trucks = Truck::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([

            'truck_type' => 'required|string',
            'capacity' => '',
        ]);

        // Update the route with the validated data
        $trucks->update($validatedData);

        // Return a response indicating success
         return redirect()->route('trucks.index')->with('success', 'Truck updated successfully.');
}


    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
    {
      $trucks = Truck::find($id);
      $trucks->delete();
      return redirect()->route('trucks.index')
        ->with('success', 'Truck deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function create()
  {
    return view('trucks.create');
  }


  public function show($id)
  {
    $truck = Truck::find($id);
    return view('trucks.show', compact('truck'));
  }

  public function edit($id)
  {
    $truck = Truck::find($id);
    return view('trucks.edit', compact('truck'));
  }

}
