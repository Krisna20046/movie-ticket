<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = strtolower($request->search);
            $query->whereRaw("lower(judul) like '%{$search}%'")
                  ->orWhereRaw("lower(deskripsi) like '%{$search}%'");
        }
        
        // Genre filter
        if ($request->has('genre') && $request->genre != 'all') {
            $query->where('genre', $request->genre);
        }
        
        $films = $query->paginate(8);
        
        // Get unique genres for filter tabs
        $genres = Film::select('genre')->distinct()->pluck('genre');
        
        return view('film_index', compact('films', 'genres'));
    }

    public function show($id)
    {
        $film = \App\Models\Film::with('jadwals.studio')->findOrFail($id);
        return view('film_detail', compact('film'));
    }

}
