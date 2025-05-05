@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des véhicules</h2>
    <a href="{{ route('vehicules.create') }}" class="btn btn-primary">Ajouter un véhicule</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Type</th>
                {{-- <th>Chauffeur</th> --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicules as $vehicule)
            <tr>
                <td>{{ $vehicule->matricule }}</td>
                <td>{{ $vehicule->type }}</td>
                {{-- <td>{{ $vehicule->chauffeur->nom ?? 'Aucun' }}</td> --}}
                <td>
                    <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        {{-- <button type="submit" class="btn btn-danger">Supprimer</button> --}}
                    </form>
                {{-- </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $vehicules->links() }}
</div>
</div>
@endsection
