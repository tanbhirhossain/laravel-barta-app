<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('frontend.auth.login');
    }

    public function login(Request $request){

        //Validation
        $credenttials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        if(Auth::attempt($credenttials)){
           $request->session()->regenerate();
           return redirect()->route('front.home');
        }

        return back()->withErrors(['credential is not matched'])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withSuccess('You have logged out successfully');

    }


}
