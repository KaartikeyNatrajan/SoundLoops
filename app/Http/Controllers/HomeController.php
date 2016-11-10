<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Auth::login(\App\User::find(1));
        $this->middleware('auth', ['except' => 'getLibrary']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('play');
    }

    public function getFavourites()
    {
        return view('favourites');
    }

    public function apiGetFavourites()
    {
        $user = Auth::user();

        $favourites = $user->favourites;

        return response()->json([
            $favourites
        ]);    
    }

    public function getUserSounds()
    {
        return view('personal');
    }

    public function apiGetUserSounds()
    {
        $user = Auth::user();

        $sounds = $user->sounds;

        return response()->json([
            $sounds
        ]);
    }

    public function getLibrary()
    {
        return view('library');
    }
    public function apiGetLibrary(Request $request)
    {
        $sounds = \App\Sound::with('user')->get();

        return $sounds->toJson();
    }
}
