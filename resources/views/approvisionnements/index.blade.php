@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des livraisons</h2>

    <!-- Formulaire de filtres -->
    <form action="{{ route('approvisionnements.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Date de début :</label>
                <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
            </div>
            <div class="col-md-3">
                <label>Date de fin :</label>
                <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
            </div>
            <div class="col-md-3">
                <label>Destination :</label>
                <select name="destination_id" class="form-control">
                    <option value="">Toutes</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Type de véhicule :</label>
                <select name="type_vehicule" class="form-control">
                    <option value="">Tous</option>
                    @foreach($types as $type)
                        <option value="{{ $type->type }}" {{ request('type_vehicule') == $type->type ? 'selected' : '' }}>{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Recherche :</label>
                <input type="text" name="search" class="form-control" placeholder="Matricule, chauffeur, quantité..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('approvisionnements.index') }}" class="btn btn-secondary w-100">Réinitialiser</a>
            </div>
        </div>
    </form>

   <!-- Bouton d'exportation -->
<div class="mb-3">
    <a href="{{ route('approvisionnements.export', request()->query()) }}" class="btn btn-success">
        Exporter en Excel
    </a>
</div>
    <!-- Affichage du total des quantités -->
    {{-- <div class="alert alert-info">
        <strong>Total Quantité : </strong> {{ number_format($totalQuantite, 2) }} litres
    </div> --}}

    <!-- Tableau des approvisionnements -->
    <table class="table table-bordered">
        <!-- Entête stylisé -->
        <thead style="background-color: black; color: white; font-weight: bold;">
            <tr>
                <th>ID</th>
                <th>Véhicule</th>
                <th>Type</th>
                <th>Chauffeur</th>
                <th>Destination</th>
                <th>Quantité (L)</th>
                {{-- <th>Actions</th> --}}
            </tr>
        </thead>

        <tbody>
            @forelse($approvisionnements as $approvisionnement)
                <tr>
                    <td>{{ $approvisionnement->id }}</td>
                    <td>{{ $approvisionnement->vehicule->matricule }}</td>
                    <td>{{ $approvisionnement->vehicule->type }}</td>
                    <td>{{ $approvisionnement->chauffeur->nom }}</td>
                    <td>{{ $approvisionnement->destination->nom }}</td>
                    <td>{{ number_format($approvisionnement->quantite) }}</td>
                    {{-- <td>
                        <a href="{{ route('approvisionnements.show', $approvisionnement->id) }}" class="btn btn-sm btn-info">Voir</a>
                        <form action="{{ route('approvisionnements.destroy', $approvisionnement->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet approvisionnement ?')">Supprimer</button>
                        </form>
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">0 resultat trouvé.</td>
                </tr>
            @endforelse
        </tbody>

        <!-- Pied de tableau stylisé -->
        <tfoot>
            <tr style="background-color: black; color: white; font-weight: bold;">
                <th colspan="5" class="text-right">Total :</th>
                <th>{{ number_format($totalQuantite) }} L</th>
                <th></th> <!-- Colonne actions vide -->
            </tr>
        </tfoot>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $approvisionnements->links() }}
    </div>
</div>
@endsection
