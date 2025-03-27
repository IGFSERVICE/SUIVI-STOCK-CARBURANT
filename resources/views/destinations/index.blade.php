@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Liste des Destinations</h2>

   

    <a href="{{ route('destinations.create') }}" class="btn btn-primary mb-3">➕ Ajouter une Destination</a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($destinations as $destination)
                <tr>
                    <td>{{ $destination->id }}</td>
                    <td>{{ $destination->nom }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $destinations->links() }}
    </div>
</div>
@endsection
