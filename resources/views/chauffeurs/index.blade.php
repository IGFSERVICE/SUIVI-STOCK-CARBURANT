@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des chauffeurs</h2>
    <a href="{{ route('chauffeurs.create') }}" class="btn btn-primary">Ajouter un chauffeur</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chauffeurs as $chauffeur)
            <tr>
                <td>{{ $chauffeur->nom }}</td>
                <td>{{ $chauffeur->telephone }}</td>
                <td>
                    <a href="{{ route('chauffeurs.edit', $chauffeur) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('chauffeurs.destroy', $chauffeur) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $chauffeurs->links() }}
    </div>
</div>
@endsection
