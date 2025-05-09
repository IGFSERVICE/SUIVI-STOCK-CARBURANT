@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($vehicule) ? 'Modifier' : 'Ajouter' }} un véhicule</h2>
    <form action="{{ isset($vehicule) ? route('vehicules.update', $vehicule) : route('vehicules.store') }}" method="POST">
        @csrf
        @isset($vehicule) @method('PUT') @endisset

        <div class="form-group">
            <label>Matricule</label>
            <input type="text" name="matricule" class="form-control" value="{{ old('matricule', $vehicule->matricule ?? '') }}" required>
            @error('matricule')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Type de véhicule</label>
            <select name="type" class="form-control" required>
                <option value="">-- Sélectionnez un type --</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ old('type', $vehicule->type ?? '') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
