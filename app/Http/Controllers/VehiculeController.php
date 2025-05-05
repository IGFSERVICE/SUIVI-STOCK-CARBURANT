<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Chauffeur;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::paginate(10); // 10 véhicules par page
        return view('vehicules.index', compact('vehicules'));
        // $vehicules = Vehicule::all();
        // return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $vehicules = Vehicule::all();
        return view('vehicules.create', compact('vehicules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:vehicules',
            'type' => 'required',
        ],[
            'matricule.unique' => 'Ce matricule existe déjà ! Veuillez en choisir un autre.',
        ]);

        $vehicule= Vehicule::create($request->all());
        return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté');
    }

    public function edit(Vehicule $vehicule)
    {
        
        return view('vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $request->validate([
            'matricule' => 'required|unique:vehicules,matricule,' . $vehicule->id,
            'type' => 'required|in:Camion,Mini-camion,Pickup',
        ],[
            'matricule.unique' => 'Ce matricule existe déjà ! Veuillez en choisir un autre.',
        ]);

        $vehicule->update($request->all());
        return redirect()->route('vehicules.index')->with('success', 'Véhicule mis à jour');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé');
    }
}
