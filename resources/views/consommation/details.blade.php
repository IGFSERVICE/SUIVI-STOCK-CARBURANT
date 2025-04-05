@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Détails des Approvisionnements</h2>

    <a href="{{ route('consommation.vehicules') }}" class="btn btn-secondary mb-3">⬅ Retour</a>

    <!-- Tableau des approvisionnements -->
    <table class="table table-bordered">
        <thead style="background-color: black; color: white; font-weight: bold;">
            <tr>
                <th>Date</th>
                <th>Matricule</th>
                <th>Type</th>
                <th>Chauffeur</th>
                <th>Destination</th>
                <th>Quantité (L)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approvisionnements as $approvisionnement)
                <tr>
                    <td>{{ $approvisionnement->date }}</td>
                    <td>{{ $approvisionnement->vehicule->matricule }}</td>
                    <td>{{ $approvisionnement->vehicule->type }}</td>
                    <td>{{ $approvisionnement->chauffeur->nom }}</td>
                    <td>{{ $approvisionnement->destination->nom }}</td>
                    <td>{{ number_format($approvisionnement->quantite) }} L</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune donnée trouvée.</td>
                </tr>
            @endforelse
        </tbody>

        <!-- Affichage du total consommé -->
        <tfoot>
            <tr style="background-color: black; color: white; font-weight: bold;">
                <td colspan="5" class="text-right">Total consommé :</td>
                <td>{{ number_format($totalConsommation) }} L</td>
            </tr>
        </tfoot>
    </table>

  
</div>
  <!-- Pagination -->
  <div class="d-flex justify-content-center">
    {{ $approvisionnements->links() }}
</div>
@endsection
