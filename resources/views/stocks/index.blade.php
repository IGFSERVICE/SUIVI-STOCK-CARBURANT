@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4"> Stock de Carburant </h2>

    <div class="row">
        <!-- Stock Précédent -->
        <div class="col-md-6">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body text-center">
                    <h4>Stock Précédent</h4>
                    <h2><strong>{{ $stock->quantite_initiale ?? 0 }} L</strong></h2>
                </div>
            </div>
        </div>

        <!-- Stock Actuel -->
        <div class="col-md-6">
            <div class="card 
                @if($stock->quantite_actuelle <= 500) bg-danger 
                @elseif($stock->quantite_actuelle <= 2000) bg-warning 
                @else bg-success @endif 
                text-white shadow">
                <div class="card-body text-center">
                    <h4>Stock Actuel</h4>
                    <h2><strong>{{ $stock->quantite_actuelle ?? 0 }} L</strong></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('stock.update') }}" class="btn btn-lg btn-warning">⚙️ Réajuster le Stock</a>
        <a href="{{ route('stock.rajout.page') }}" class="btn btn-lg btn-success">➕ Rajouter du Stock</a>
    </div>
</div>
@endsection
