<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('created_by', Auth::user()->id)->where('type', 1)->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255',
        ]);

        $user = new User();
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->password = Hash::make($validateData['password']);
        $user->created_by = Auth()->user()->id;
        $user->type = 1;

        $user->save();
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        if($request->password){
        $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
