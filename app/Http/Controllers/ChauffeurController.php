<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
    public function index()
    {
        $chauffeurs = Chauffeur::paginate(10); 
        return view('chauffeurs.index', compact('chauffeurs'));
    }

    public function create()
    {
        return view('chauffeurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'telephone' => 'required|unique:chauffeurs,telephone,' . ($chauffeur->id ?? 'NULL'),
        ], [
            'telephone.unique' => 'Ce numéro de téléphone est déjà attribué à un autre chauffeur.'
        ]);

        Chauffeur::create($request->all());
        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur ajouté avec succès !');
    }

    public function edit(Chauffeur $chauffeur)
    {
        return view('chauffeurs.edit', compact('chauffeur'));
    }

    public function update(Request $request, Chauffeur $chauffeur)
{
    $request->validate([
        'nom' => 'required',
        'telephone' => 'required|unique:chauffeurs,telephone,' . $chauffeur->id,
    ], [
        'telephone.unique' => 'Ce numéro de téléphone est déjà attribué à un autre chauffeur.'
    ]);

    $chauffeur->update($request->only(['nom', 'telephone']));
    return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur mis à jour');
}

    public function destroy(Chauffeur $chauffeur)
    {
        $chauffeur->delete();
        return redirect()->route('chauffeurs.index')->with('success', 'Chauffeur supprimé');
    }
}
