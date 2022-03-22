<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Posts::where('status',1)->orderby('updated_at','desc')->get();
        // dd(Challenge::where('status',1)->orderby('update_at','desc')->get());
        $challs = Challenge::where('status',1)->get(); //->orderby('update_at','desc')
        // dd($challs->title);
        $listUser = User::all();
        

        return view('home', compact('posts', 'challs','listUser'));
    }
}   
