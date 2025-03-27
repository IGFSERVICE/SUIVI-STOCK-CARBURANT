<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\Stock;
use Illuminate\Http\Request;

class InventaireController extends Controller {
    public function index() {
        $inventaires = Inventaire::orderBy('date_ajustement', 'desc')->get();
        return view('inventaires.index', compact('inventaires'));
    }

    public function create() {
        return view('inventaires.create');
    }

    public function store(Request $request) {
        $request->validate([
            'date' => 'required|date',
            'quantite_ajoutee' => 'required|integer',
            'motif' => 'nullable|string',
        ]);

        // Enregistrer l'ajustement
        Inventaire::create($request->all());

        // Mettre à jour le stock
        $stock = Stock::latest()->first();
        if ($stock) {
            $stock->update(['quantite_actuelle' => $stock->quantite_actuelle + $request->quantite_ajoutee]);
        }

        return redirect()->route('inventaires.index')->with('success', 'Inventaire mis à jour.');
    }
}

