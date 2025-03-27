@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Réajuster le Stock</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('stock.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nouvelle Quantité (L) :</label>
            <input type="number" name="nouvelle_quantite" class="form-control" required>

            @error('nouvelle_quantite')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>
@endsection
