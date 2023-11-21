<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){

        $posts = Post::With('user')
                      ->Where('post_status', 1)
                      ->OrderBy('created_at', 'DESC')
                      ->paginate(5);

        $posts->each(function ($post) {
            $post->timeAgo = Carbon::parse($post->created_at)->diffForHumans();
        });

        return view("frontend.home.home", compact("posts"));
    }

   
}
