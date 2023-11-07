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
        $profile = User::find($user);

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
       $user = Auth::user()->id;

       $userprofile = User::find($user);
       $userprofile->name = $request->first_name.' '.$request->last_name;
       $userprofile->email = $request->email;
       $userprofile->password = Hash::make($request->password);
       $userprofile->save();

       $bio = Userprofile::Where('user_id', Auth::user()->id)->first();
       $bio->bio = $request->bio;
       $bio->save();

       return redirect()->back()->with('success','Profile Updated Successfully');
        
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Userprofile $userprofile)
    {
        //
    }
}
