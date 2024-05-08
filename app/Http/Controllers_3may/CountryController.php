<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;


class CountryController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
          $countries = Country::where('created_by', Auth::user()->creatorId())->get();
          return view('countries.index', compact('countries'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|max:255',
            ]);

            $created_by = Auth::user()->creatorId();

            Country::create([
                'name' => $request->name,
                'created_by' => $created_by,
            ]);
          return redirect()->route('countries.index')
            ->with('success', 'countries created successfully.');
        }
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
          $request->validate([
            'name' => 'required|max:255',
            // 'body' => 'required',
          ]);
          $country = Country::find($id);
          $country->update($request->all());
          return redirect()->route('countries.index')
            ->with('success', 'countries updated successfully.');
        }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
          $country = Country::find($id);
          $country->delete();
          return redirect()->route('countries.index')
            ->with('success', 'country deleted successfully');
        }
        // routes functions
        /**
         * Show the form for creating a new post.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
          return view('countries.create');
        }
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
          $country = Country::find($id);
          return view('countries.show', compact('country'));
        }
        /**
         * Show the form for editing the specified post.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
          $country = Country::find($id);
          return view('countries.edit', compact('country'));
        }
      }
