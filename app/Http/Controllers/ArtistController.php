<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display artist profile with services and artworks
     */
    public function show(User $artist)
    {
        // Verify user is an artist
        if ($artist->role !== 'artist') {
            abort(404);
        }

        // Get artist's services and artworks
        $services = $artist->services()->get();
        $artworks = $artist->artworks()->get();

        return view('artists.show', compact('artist', 'services', 'artworks'));
    }
}
