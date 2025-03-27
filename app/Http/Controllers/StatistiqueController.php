<?php
namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des véhicules
        $vehicules = Vehicule::all();

        // Récupération des filtres utilisateur
        $vehicule_id = $request->input('vehicule_id');
        $type_statistique = $request->input('type_statistique', 'intervalle');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        // Gestion des dates
        if ($type_statistique == '2_mois') {
            $date_debut = Carbon::now()->subMonths(2);
            $date_fin = Carbon::now();
        } elseif ($type_statistique == '3_mois') {
            $date_debut = Carbon::now()->subMonths(3);
            $date_fin = Carbon::now();
        } else {
            // Vérifier si l'utilisateur a saisi une date
            $date_debut = $date_debut ? Carbon::parse($date_debut) : Carbon::now()->subMonth();
            $date_fin = $date_fin ? Carbon::parse($date_fin) : Carbon::now();
        }

        
        // $date_debut = $date_debut->format('Y-m-d');
        // $date_fin = $date_fin->format('Y-m-d');

        
        // dd($date_debut, $date_fin);

        // Vérifier si un véhicule est sélectionné
        $approvisionnement = null;
        if ($vehicule_id) {
            $approvisionnement = Approvisionnement::where('vehicule_id', $vehicule_id)
                ->where('date', '>=', "$date_debut")
                ->where('date', '<=', "$date_fin")
                ->sum('quantite');
        }

        return view('statistiques.index', compact('vehicules', 'vehicule_id', 'type_statistique', 'date_debut', 'date_fin', 'approvisionnement'));
    }
}



