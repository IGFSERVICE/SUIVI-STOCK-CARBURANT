@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion de l'Inventaire</h2>
    <a href="{{ route('inventaires.create') }}" class="btn btn-primary">Ajuster</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Quantité ajoutée</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventaires as $inventaire)
            <tr>
                <td>{{ $inventaire->date }}</td>
                <td>{{ $inventaire->quantite_ajoutee }} litres</td>
                <td>{{ $inventaire->motif }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
