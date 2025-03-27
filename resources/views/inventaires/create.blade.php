@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un ajustement d'inventaire</h2>

    <form action="{{ route('inventaires.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Date :</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Quantité ajoutée (+ ou -) :</label>
            <input type="number" name="quantite_ajoutee" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Motif :</label>
            <textarea name="motif" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
