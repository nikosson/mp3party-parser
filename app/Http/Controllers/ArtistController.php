<?php

namespace App\Http\Controllers;

use App\Models\Artist;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::all();

        return view('index', compact('artists'));
    }

    public function get(int $artistId)
    {
        $artist = Artist::with(['tracks' => function($query) {
            $query->downloaded();
        }])->findOrFail($artistId);

        return view('artist', [
            'artist' => $artist,
            'tracks' => $artist->tracks
        ]);
    }
}
