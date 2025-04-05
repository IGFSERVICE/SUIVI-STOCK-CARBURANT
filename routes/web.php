<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\ApprovisionnementController;



// Tableau de bord (AdminLTE)
// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Chauffeurs
Route::resource('chauffeurs', ChauffeurController::class);

// Véhicules
Route::resource('vehicules', VehiculeController::class);


// Stock
Route::prefix('stock')->group(function () {
    Route::get('/index', [StockController::class, 'index'])->name('stocks.index'); // Liste des stocks
    Route::get('/reajuster', [StockController::class, 'reajuster'])->name('stock.update'); // Réajustement du stock
    Route::post('/reajuster', [StockController::class, 'updateStock'])->name('stock.reajuster');
    Route::get('/historique', [StockController::class, 'historique'])->name('stock.historique'); // Historique des ajustements
});

// Routes pour le rajout de stock
Route::get('/rajout', [StockController::class, 'rajoutStock'])->name('stock.rajout.page');
Route::post('/rajout', [StockController::class, 'ajouterStock'])->name('stock.rajout');

// Approvisionnements vehicules
Route::get('/approvisionnements', [ApprovisionnementController::class, 'index'])->name('approvisionnements.index');
// Route::get('/approvisionnements/{id}', [ApprovisionnementController::class, 'show'])->name('approvisionnements.show');
Route::delete('/approvisionnements/{id}', [ApprovisionnementController::class, 'destroy'])->name('approvisionnements.destroy');
Route::get('/approvisionnements/create', [ApprovisionnementController::class, 'create'])->name('approvisionnements.create');
Route::post('/approvisionnements', [ApprovisionnementController::class, 'store'])->name('approvisionnements.store');
Route::get('approvisionnements/export', [App\Http\Controllers\ApprovisionnementController::class, 'export'])->name('approvisionnements.export');
// Statistiques
Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques');

// Consommation
Route::get('/consommation', [ApprovisionnementController::class, 'consommation'])->name('approvisionnements.consommation');
Route::get('/consommation-vehicules', [ConsommationController::class, 'index'])->name('consommation.vehicules');
Route::get('/consommation/details', [ConsommationController::class, 'details'])->name('consommation.details');

Route::resource('destinations', DestinationController::class);
