@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Ajouter une Destination</h2>

    <form action="{{ route('destinations.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nom de la destination :</label>
            <input type="text" name="nom" class="form-control" required>
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('destinations.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
