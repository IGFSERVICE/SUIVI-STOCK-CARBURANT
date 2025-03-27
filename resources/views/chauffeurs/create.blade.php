@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($chauffeur) ? 'Modifier' : 'Ajouter' }} un chauffeur</h2>
    <form action="{{ isset($chauffeur) ? route('chauffeurs.update', $chauffeur) : route('chauffeurs.store') }}" method="POST">
        @csrf
        @isset($chauffeur) @method('PUT') @endisset
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $chauffeur->nom ?? '') }}" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
            @error('telephone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
