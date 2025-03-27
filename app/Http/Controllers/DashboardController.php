<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use App\Models\Vehicule;
use App\Models\Stock;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stock = Stock::latest()->first();
        $nombreChauffeurs = Chauffeur::count();
        $nombreVehicules = Vehicule::count();
 
        return view('dashboard', compact('stock', 'nombreChauffeurs', 'nombreVehicules'));
    }
}
