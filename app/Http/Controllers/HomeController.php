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
        // Auth::login(\App\User::find(1));
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
            'data' => $favourites
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
            'data' => $sounds
        ]);
    }

    public function getLibrary()
    {
        return view('library');
    }
    public function apiGetLibrary(Request $request)
    {
        $sounds = \App\Sound::with('user')->orderBy('created_at', 'desc')->paginate(10);

        $favourites = Auth::user()->favourites->pluck('soundId')->all();

        foreach ($sounds as &$sound)
        {
            if(array_search($sound->soundId, $favourites) !== false)
            {
                $sound->hasLiked = true;
            }
            else
            {
                $sound->hasLiked = false;
            }
        }

        return response()->json([
            'data' => $sounds
        ]);
    }

    public function apiToggleLike($soundId)
    {
        $user = Auth::user();
        $sound = \App\Sound::find($soundId);

        if(is_null($sound))
        {
            return response()->json([
                'data' => 'sound not found'
            ], 422);
        }

        if($user->hasFavourited($soundId))
        {
            $user->favourites()->detach($sound);
            $sound->decrementLikeCount();
        }
        else
        {
            $user->favourites()->attach($sound);
            $sound->incrementLikeCount();
        }

        return response()->json([
            'data' => 'Successfully liked'
        ], 200);
    }

    public function saveSound(Request $request)
    {
        $user = Auth::user();

        $sound = new \App\Sound;
        $sound->userId = $user->userId;
        $sound->data = $request->jsonData;
        $sound->save();

    }
}
