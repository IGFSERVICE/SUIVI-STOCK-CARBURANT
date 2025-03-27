@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle livraison</h2>

    <form action="{{ route('approvisionnements.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Date :</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Véhicule :</label>
            <select name="vehicule_id" class="form-control" required>
                @foreach ($vehicules as $vehicule)
                    <option value="{{ $vehicule->id }}">{{ $vehicule->matricule }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Chauffeur :</label>
            <select name="chauffeur_id" class="form-control" required>
                @foreach ($chauffeurs as $chauffeur)
                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Destination :</label>
            <select name="destination_id" class="form-control" required>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Quantité (L) :</label>
            <input type="number" name="quantite" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Valider</button>
    </form>
</div>
@endsection
