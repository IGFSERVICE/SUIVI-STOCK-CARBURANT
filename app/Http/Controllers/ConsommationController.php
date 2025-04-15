<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Models\Approvisionnement;
use Illuminate\Support\Facades\DB;

class ConsommationController extends Controller
{
    public function index(Request $request)
{
    $dateDebut = $request->input('date_debut');
    $dateFin = $request->input('date_fin');
    $typeVehicule = $request->input('type_vehicule');

    // Requête pour calculer la consommation totale par véhicule
    $query = Approvisionnement::selectRaw('vehicule_id, SUM(quantite) as total_quantite')
        ->with('vehicule')
        ->groupBy('vehicule_id');
    
    $query1 = Approvisionnement::with(['vehicule', 'chauffeur', 'destination']);
        // Appliquer les filtres à $query1
    if ($dateDebut) {
        $query1->where('date', '>=', $dateDebut);
    }
    if ($dateFin) {
        $query1->where('date', '<=', $dateFin);
    }
    if ($typeVehicule) {
        $query1->whereHas('vehicule', function ($q) use ($typeVehicule) {
            $q->where('type', $typeVehicule);
        });
    }



    // Appliquer le filtre de date
    if ($dateDebut) {
        $query->where('date', '>=', $dateDebut);
    }
    if ($dateFin) {
        $query->where('date', '<=', $dateFin);
    }

    // Appliquer le filtre par type de véhicule
    if ($typeVehicule) {
        $query->whereHas('vehicule', function ($q) use ($typeVehicule) {
            $q->where('type', $typeVehicule);
        });
    }

     // Calcul du total général (somme de toutes les consommations filtrées, même hors pagination)
     $totalGeneral = $query1->sum('quantite');

    // Exécuter la requête avec pagination
    $consommations = $query->paginate(10);

   

    // Récupérer la liste des types de véhicules disponibles
    $types = Vehicule::select('type')->distinct()->get();

    return view('consommation.index', compact('consommations', 'types','totalGeneral'));
}

    

    public function details(Request $request)
{
    $vehiculeId = $request->input('vehicule_id');
    $dateDebut = $request->input('date_debut');
    $dateFin = $request->input('date_fin');

    $query = Approvisionnement::where('vehicule_id', $vehiculeId)
    ->with(['vehicule', 'chauffeur', 'destination'])
    ->orderBy('date', 'desc');

// Appliquer les filtres de date
if ($dateDebut) {
    $query->where('date', '>=', $dateDebut);
}
if ($dateFin) {
    $query->where('date', '<=', $dateFin);
}

// Calcul du total consommé
$totalConsommation = $query->sum('quantite');

// Pagination
$approvisionnements = $query->paginate(5)->appends([
    'vehicule_id' => $vehiculeId,
    'date_debut' => $dateDebut,
    'date_fin' => $dateFin,
]);

   

    return view('consommation.details', compact('approvisionnements', 'totalConsommation'));
}

}
