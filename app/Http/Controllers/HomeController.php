<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('home', compact('posts'));
    }

    public function downloadLaravelFile()
    {
        return Storage::download('/public/Laravel.pdf');
    }

    public function downloadFajarPicture()
    {
        return response()->download('download/fajar.jpg');
    }

    public function viewLaravelFile()
    {
        return response()->file('/public/Laravel.pdf');
    }

    public function viewFajarPicture()
    {
        return response()->file('download/fajar.jpg');
    }

}
