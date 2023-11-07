<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('frontend.auth.register');
    }

    public function store(Request $request){
        //return dd($request->all());
       
        $validateData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ],[
            'first_name.required' => 'First Name field is required',
            'last_name.required' => 'Last Name field is required',
            'password.required' => 'Password field is required',
            'email.email' => 'Email field must be email address'
        ]);

        // $validateData['password'] = bcrypt($validateData['password']);
        $validatedData['password'] = Hash::make($request->password);
        $validateData['name'] = $validateData['first_name'].' '.$validateData['last_name'];

        //dd($validateData);
        User::create($validateData);

        return redirect()->back()->with('success','User Registration Successful');
        
    }
}
