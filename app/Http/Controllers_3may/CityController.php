<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;

use Illuminate\Support\Facades\Auth;





class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::where('created_by', Auth::user()->creatorId())->get();
        $countries = Country::where('created_by', Auth::user()->creatorId())->get();


        // dd($cities);
        return view('cities.index', compact('cities', 'countries'));
    }

    // public function index()
    // {
    //     $cities = Country::all();

    //     // $city = City::find($id);

    //      $cityNames = City::pluck('city_name');
    //     // dd($cities);
    //     return view('cities.index', compact('cities', 'cityNames'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'city_name' => 'required',
          ]);
          $created_by = Auth::user()->creatorId();

        //   dd($created_by);

          City::create([
            'country_id' => $request->country_id,
            'city_name' => $request->city_name,
            'created_by' => $created_by, // Set the created_by field
        ]);

          return redirect()->route('cities.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'country_id' => 'required',
            'city_name' => 'required',
          ]);
          $city = City::find($id);
          $city->update($request->all());
          return redirect()->route('cities.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);
    $city->delete();
    return redirect()->route('cities.index')
      ->with('success', 'Post deleted successfully');
    }

    public function create()
    {
      $countries = Country::where('created_by', Auth::user()->creatorId())->get();
      return view('cities.create', compact('cities'));
    }

    public function show($id)
    {
      $city = City::find($id);
      return view('cities.show', compact('city'));
    }

    public function edit($id)
    {
      $city = City::find($id);
      $cities = City::where('created_by', Auth::user()->creatorId())->get();
      $countries = Country::where('created_by', Auth::user()->creatorId())->get();

      return view('cities.edit', compact('cities', 'city', 'countries'));
    }
}
