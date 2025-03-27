<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::orderBy('id')->paginate(10);
        return view('destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('destinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:destinations,nom',
        ]);

        Destination::create(['nom' => $request->nom]);

        return redirect()->route('destinations.index')->with('success', 'Destination ajoutée avec succès.');
    }
}
