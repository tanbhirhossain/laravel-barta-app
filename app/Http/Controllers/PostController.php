<?php

namespace App\Http\Controllers;


use App\Models\Post;
use Illuminate\Http\Request;
use Auth;
// use Toastr;
use Carbon\Carbon;

use Brian2694\Toastr\Facades\Toastr;
use Exception;


class PostController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "post_text" => 'required|string|min:5'
        ]);
//dd($request->all());
        try{
            Post::create([
                "post_text" => $request->input('post_text'),
                "user_id" => Auth::user()->id
            ]);

            Toastr::success('Your post is successfully posted', 'Success');

        }catch(\Exception $e){
            Toastr::error('Error posting your post', 'Error');
        }

       

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $post = Post::Where('id', $post->id)->first();
        $posts = Post::With('user')
        ->Where('post_status', 1)
        ->OrderBy('created_at', 'DESC')
        ->paginate(5);

            $posts->each(function ($post) {
            $post->timeAgo = Carbon::parse($post->created_at)->diffForHumans();
            });

       // dd($post);
        return view('frontend.home.home', compact('post', 'posts'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_text' => 'required',
            
        ]);

        $post = Post::find($post->id);
    
        $post->update([
            'post_text' => $request->input('post_text'),
            
        ]);

        Toastr::success('Your Post is Updated Successfully');

        return redirect()->route('front.home');

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
{
    $post = Post::find($post->id);

    if (!$post) {
        // Handle the case where the post is not found, perhaps show an error message
        Toastr::error('Post not found.');
        return redirect()->route('front.home');
    }

    $post->delete();
    Toastr::success('Your Post is deleted Successfully');

    return redirect()->route('front.home');
}
}
