<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        // $profile = User::find($user);
        $profile = User::with('userProfile')->find($user);


        return view('frontend.profile.profile', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Userprofile $userprofile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Userprofile $userprofile)
    {
        $user = Auth::user()->id;

        $profile = User::with('userProfile')->find($user);
        // dd($userprofile);
        $name = explode(' ', $profile->name);
     
        return view('frontend.profile.update-profile', compact('profile', 'name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Userprofile $userprofile)
    {
        $validatedData = $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'bio' => 'nullable|string',
        ]);
    
        $user = auth()->user();
    
        $user->name = $validatedData['first-name'] . ' ' . $validatedData['last-name'];
        $user->email = $validatedData['email'];
    
        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }
    
        $user->save();
    
        if ($user->userProfile) {
            $user->userProfile->update(['bio' => $validatedData['bio']]);
        } else {
            $user->userProfile()->create(['bio' => $validatedData['bio']]);
        }
    
        return redirect()->route('front.profile.edit')->with('success', 'Profile updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Userprofile $userprofile)
    {
        //
    }
}
