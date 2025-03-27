<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Approvisionnement;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApprovisionnementsExport;

class ApprovisionnementController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des filtres utilisateur
        $search = $request->input('search');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $destination_id = $request->input('destination_id');
        $type_vehicule = $request->input('type_vehicule'); // 🔹 Nouveau filtre

        // Récupération des destinations et modèles de véhicules
        $destinations = Destination::all();
        $types = Vehicule::select('type')->distinct()->get();

        // Création de la requête de base
        $query = Approvisionnement::with(['vehicule', 'chauffeur', 'destination']);

        // Filtrage par date
        if ($date_debut && $date_fin) {
            $query->whereBetween('date', [$date_debut, $date_fin]);
        }

        // Filtrage par destination
        if ($destination_id) {
            $query->where('destination_id', $destination_id);
        }

        // Filtrage par modèle de véhicule
        if ($type_vehicule) {
            $query->whereHas('vehicule', function ($q) use ($type_vehicule) {
                $q->where('type', 'like', "%$type_vehicule%");
            });
        }

        // Filtrage par recherche
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('vehicule', function ($subQuery) use ($search) {
                    $subQuery->where('matricule', 'like', "%$search%");
                })
                ->orWhereHas('chauffeur', function ($subQuery) use ($search) {
                    $subQuery->where('nom', 'like', "%$search%");
                })
                ->orWhere('quantite', 'like', "%$search%");
            });
        }

        // Calcul du total des quantités AVANT la pagination
        $totalQuantite = $query->clone()->sum('quantite');

        // Appliquer la pagination
        $approvisionnements = $query->orderBy('date', 'desc')->paginate(10)->appends($request->query());

        return view('approvisionnements.index', compact('approvisionnements', 'totalQuantite', 'destinations', 'types'));
    }

    public function create()
    {
        $destinations = Destination::all();
        $vehicules = Vehicule::all();
        $chauffeurs = Chauffeur::all();

        return view('approvisionnements.create', compact('vehicules', 'chauffeurs', 'destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'vehicule_id' => 'required|exists:vehicules,id',
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'quantite' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        // Vérification du stock disponible
        $stock = Stock::first();
        if ($stock->quantite_actuelle < $request->quantite) {
            return redirect()->back()->with('error', 'Stock insuffisant !');
        }

        // Enregistrement de l’approvisionnement
        Approvisionnement::create($request->all());

        // Réduction du stock
        $stock->decrement('quantite_actuelle', $request->quantite);

        return redirect()->route('approvisionnements.index')->with('success', 'Livraison effectuée avec succès.');
    }

    public function show($id)
    {
        $approvisionnement = Approvisionnement::with(['vehicule', 'chauffeur', 'destination'])->findOrFail($id);
        return view('approvisionnements.show', compact('approvisionnement'));
    }

    public function destroy($id)
    {
        $approvisionnement = Approvisionnement::findOrFail($id);
        
        // Remboursement du stock avant suppression
        $stock = Stock::first();
        $stock->increment('quantite_actuelle', $approvisionnement->quantite);

        $approvisionnement->delete();
        return redirect()->route('approvisionnements.index')->with('success', 'Approvisionnement supprimé.');
    }

    public function export(Request $request)
    {
        // Applique les filtres si nécessaires
        $approvisionnements = Approvisionnement::query();
    
        if ($request->filled('date_debut')) {
            $approvisionnements->where('date', '>=', $request->date_debut);
        }
    
        if ($request->filled('date_fin')) {
            $approvisionnements->where('date', '<=', $request->date_fin);
        }
    
        if ($request->filled('destination_id')) {
            $approvisionnements->where('destination_id', $request->destination_id);
        }
    
        if ($request->filled('type_vehicule')) {
            $approvisionnements->whereHas('vehicule', function ($query) use ($request) {
                $query->where('type', $request->type_vehicule);
            });
        }
    
        if ($request->filled('search')) {
            $approvisionnements->where(function ($query) use ($request) {
                $query->whereHas('vehicule', function ($query) use ($request) {
                    $query->where('matricule', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('chauffeur', function ($query) use ($request) {
                    $query->where('nom', 'like', '%' . $request->search . '%');
                })
                ->orWhere('quantite', 'like', '%' . $request->search . '%');
            });
        }
    
        // Exporter les approvisionnements en excluant la colonne "Actions"
        return Excel::download(new ApprovisionnementsExport($approvisionnements->get()), 'approvisionnements.xlsx');
    }
    

    public function consommation(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        $query = Approvisionnement::with('vehicule')
            ->selectRaw('vehicule_id, SUM(quantite) as total_consommation')
            ->groupBy('vehicule_id')
            ->orderByDesc('total_consommation');

        if ($date_debut && $date_fin) {
            $query->whereBetween('date', [$date_debut, $date_fin]);
        }

        $consommation = $query->get();

        // Formater les données pour le graphique
        $labels = $consommation->pluck('vehicule.matricule');
        $data = $consommation->pluck('total_consommation');

        return view('approvisionnements.consommation', compact('labels', 'data', 'date_debut', 'date_fin'));
    }
}
