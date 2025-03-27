@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center text-primary">📊 Statistiques de Consommation</h2>

    <div class="card shadow p-4">
        <form action="{{ route('statistiques') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="vehicule_id"><strong>🚗 Véhicule :</strong></label>
                    <select name="vehicule_id" id="vehicule_id" class="form-control">
                        <option value="">-- Choisir un véhicule --</option>
                        @foreach($vehicules as $vehicule)
                            <option value="{{ $vehicule->id }}" {{ request('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                {{ $vehicule->matricule }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="type_statistique"><strong>📆 Type de statistique :</strong></label>
                    <select name="type_statistique" id="type_statistique" class="form-control" onchange="toggleDateFields()">
                        <option value="intervalle" {{ request('type_statistique') == 'intervalle' ? 'selected' : '' }}>Par intervalle de dates</option>
                        <option value="2_mois" {{ request('type_statistique') == '2_mois' ? 'selected' : '' }}>2 derniers mois</option>
                        <option value="3_mois" {{ request('type_statistique') == '3_mois' ? 'selected' : '' }}>3 derniers mois</option>
                    </select>
                </div>

                <div class="col-md-3 date-fields">
                    <label for="date_debut"><strong>📅 Date début :</strong></label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ $date_debut }}">
                </div>

                <div class="col-md-3 date-fields">
                    <label for="date_fin"><strong>📅 Date fin :</strong></label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ $date_fin }}">
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
                <a href="{{ route('statistiques') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Effacer le filtre</a>
            </div>
        </form>
    </div>

    @if($approvisionnement !== null)
    <div class="card mt-4 shadow-lg">
        <div class="card-body text-center">
            <h4 class="mb-3">📌 Résultats pour <strong class="text-primary">{{ request('vehicule_id') ? $vehicules->where('id', request('vehicule_id'))->first()->matricule : 'Non sélectionné' }}</strong></h4>
            
            <p>
                <span class="badge bg-info text-dark">📆 Période : 
                    {{ \Carbon\Carbon::parse($date_debut)->format('d-m-Y') }} - 
                    {{ \Carbon\Carbon::parse($date_fin)->format('d-m-Y') }}
                </span>
            </p>

            <p class="mt-3">
                <span class="badge bg-success text-white" style="font-size: 1.5rem; padding: 15px;">
                    ⛽ Total Approvisionné : <strong>{{ $approvisionnement }} litres</strong>
                </span>
            </p>
        </div>
    </div>
    @endif
</div>

{{-- JavaScript pour masquer/afficher les champs de date --}}
<script>
    function toggleDateFields() {
        let typeStatistique = document.getElementById("type_statistique").value;
        let dateFields = document.querySelectorAll(".date-fields");

        if (typeStatistique === "2_mois" || typeStatistique === "3_mois") {
            dateFields.forEach(field => field.style.display = "none");
        } else {
            dateFields.forEach(field => field.style.display = "block");
        }
    }

    // Exécuter la fonction au chargement de la page
    document.addEventListener("DOMContentLoaded", toggleDateFields);
</script>
@endsection
