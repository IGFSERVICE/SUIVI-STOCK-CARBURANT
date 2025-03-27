@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rajouter du Stock</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('stock.rajout') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Quantité à rajouter (L) :</label>
            <input type="number" name="quantite_ajoutee" class="form-control" required>

            @error('quantite_ajoutee')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">➕ Rajouter</button>
        <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Retour</a>

    </form>
</div>
@endsection
