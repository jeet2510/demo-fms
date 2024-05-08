<?php

namespace App\Http\Controllers;
use App\Models\Border;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class BorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $countries = Country::where('created_by', Auth::user()->creatorId())->get();
    //    dd($countries);
       $borders = Border::where('created_by', Auth::user()->creatorId())->get();
       return view('borders.index', compact('borders', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'border_name' => 'required|string|max:100',
            'border_type' => 'required|string|max:50',
            'border_charges' => 'nullable|integer|min:0',
            // 'created_by' => 'required|integer',
        ]);

        $border = new Border();

        $border->country_id = $validatedData['country_id'];
        $border->border_name = $validatedData['border_name'];
        $border->border_type = $validatedData['border_type'];
        $border->border_charges = $validatedData['border_charges'] ?? 0;
        $border->created_by = Auth::user()->creatorId();
        $border->save();


        return redirect()->route('borders.index')->with('success', 'Border created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, Border $border)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'border_name' => 'required|string|max:100',
            'border_type' => 'required|string|max:50',
            'border_charges' => 'nullable|integer|min:0',
            // 'created_by' => 'required|integer',
        ]);

        // Populate the model with validated data
        $border->country_id = $validatedData['country_id'];
        $border->border_name = $validatedData['border_name'];
        $border->border_type = $validatedData['border_type'];
        $border->border_charges = $validatedData['border_charges'] ?? 0;
        // $border->created_by = $validatedData['created_by'];

        // Save the updated model to the database
        $border->save();

        // Optionally, you can redirect the user after successful update
        return redirect()->route('borders.index')->with('success', 'Border updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function destroy($id)
    {
      $border = Border::find($id);
      $border->delete();
      return redirect()->route('borders.index')
        ->with('success', 'Borders deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function create()
    {

        $countries = Country::where('created_by', Auth::user()->creatorId())->get();

        // dd($countries);
        return view('borders.create', compact('countries'));
    }



    public function show($id)
    {
        $border = Border::find($id);
        return view('borders.show', compact('border'));
    }

    public function edit($id)
  {
    $border = Border::find($id);
    $countries = Country::where('created_by', Auth::user()->creatorId())->get();

    return view('borders.edit', compact('border', 'countries'));
  }
}
