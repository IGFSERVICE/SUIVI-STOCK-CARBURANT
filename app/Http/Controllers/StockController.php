<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Inventaire;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Afficher l'état du stock
     */
    public function index()
    {
        $stock = Stock::latest()->first();
        return view('stocks.index', compact('stock'));
    }

    /**
     * Afficher le formulaire de réajustement
     */
    public function reajuster()
    {
        return view('stocks.reajuster');
    }

    /**
     * Mettre à jour le stock (réajustement)
     */
    public function updateStock(Request $request)
    {
        $request->validate([
            'nouvelle_quantite' => 'required|integer|min:1',
        ]);

        $stock = Stock::first();
        $ancienne_quantite = $stock->quantite_actuelle ?? 0;
        $nouvelle_quantite = $request->nouvelle_quantite;
        $difference = $nouvelle_quantite - $ancienne_quantite;

        // Enregistrer l'historique du réajustement
        Inventaire::create([
            'ancienne_quantite' => $ancienne_quantite,
            'nouvelle_quantite' => $nouvelle_quantite,
            'difference' => $difference,
            'type_operation' => 'Réajustement',
            'date_ajustement' => Carbon::now(),
        ]);

        // Mettre à jour le stock
        $stock->update([
            'quantite_initiale' => $ancienne_quantite,
            'quantite_actuelle' => $nouvelle_quantite
        ]);

        return redirect()->route('stocks.index')->with('success', 'Stock réajusté avec succès.');
    }

    /**
     * Afficher le formulaire de rajout de stock
     */
    public function rajoutStock()
    {
        return view('stocks.rajoutStock');
    }

    /**
     * Rajouter du stock
     */
    public function ajouterStock(Request $request)
    {
        $request->validate([
            'quantite_ajoutee' => 'required|integer|min:1',
        ]);

        $stock = Stock::first();
        $ancienne_quantite = $stock->quantite_actuelle ?? 0;
        $nouvelle_quantite = $ancienne_quantite + $request->quantite_ajoutee;

        // Enregistrer l'historique du rajout
        Inventaire::create([
            'ancienne_quantite' => $ancienne_quantite,
            'nouvelle_quantite' => $nouvelle_quantite,
            'difference' => $request->quantite_ajoutee,
            'type_operation' => 'Rajout',
            'date_ajustement' => Carbon::now(),
        ]);

        // Mettre à jour le stock
        $stock->update([
            'quantite_initiale' => $ancienne_quantite,
            'quantite_actuelle' => $nouvelle_quantite
        ]);

        return redirect()->route('stocks.index')->with('success', 'Stock rajouté avec succès.');
    }

    /**
     * Afficher l'historique des ajustements et rajouts
     */
    public function historique()
    {
        $historiques = Inventaire::orderBy('date_ajustement', 'desc')->paginate(10);
        return view('stocks.historique', compact('historiques'));
    }
}
