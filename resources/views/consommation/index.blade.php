@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Consommation Totale des Véhicules</h2>

    <!-- Formulaire de filtrage -->
    <form action="{{ route('consommation.vehicules') }}" method="GET" class="mb-4">
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
                <label>Type de véhicule :</label>
                <select name="type_vehicule" class="form-control">
                    <option value="">Tous</option>
                    @foreach($types as $type)
                        <option value="{{ $type->type }}" {{ request('type_vehicule') == $type->type ? 'selected' : '' }}>
                            {{ $type->type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('consommation.vehicules') }}" class="btn btn-secondary w-100">Réinitialiser</a>
            </div>
        </div>
    </form>

    <!-- Tableau des consommations -->
    <table class="table table-bordered">
        <thead style="background-color: black; color: white; font-weight: bold;">
            <tr>
                <th>Véhicule</th>
                <th>Type</th>
                <th>Total Consommé (L)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           
            @forelse($consommations as $consommation)
                <tr>
                    <td>{{ $consommation->vehicule->matricule }}</td>
                    <td>{{ $consommation->vehicule->type }}</td>
                    <td>{{ number_format($consommation->total_quantite) }} L</td>
                    <td>
                        <a href="{{ route('consommation.details', ['vehicule_id' => $consommation->vehicule->id, 'date_debut' => request('date_debut'), 'date_fin' => request('date_fin')]) }}" 
                           class="btn btn-sm btn-info">
                            Voir Détails
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucune donnée trouvée.</td>
                </tr>
            @endforelse
        </tbody>

        <!-- Affichage du total général -->
        <tr style="background-color: black; color: white; font-weight: bold;">
            <td colspan="2" class="text-right">Total général :</td>
            <td>{{ number_format($totalGeneral) }} L</td>
            <td></td>
        </tr>
    </tfoot>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $consommations->links() }}
    </div>
</div>
@endsection
