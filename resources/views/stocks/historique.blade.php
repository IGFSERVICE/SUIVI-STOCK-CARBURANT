@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Historique des Mouvements de Stock</h2>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Ancienne Quantité (L)</th>
                <th>Nouvelle Quantité (L)</th>
                <th>Différence (L)</th>
                <th>Type d'Opération</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historiques as $historique)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($historique->date_ajustement)->format('d/m/Y H:i') }}</td>
                    <td>{{ $historique->ancienne_quantite }}</td>
                    <td>{{ $historique->nouvelle_quantite }}</td>
                    <td>{{ $historique->difference }}</td>
                    <td>
                        <span class="badge {{ $historique->type_operation == 'Rajout' ? 'bg-success' : 'bg-warning' }}">
                            {{ $historique->type_operation }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $historiques->links() }}
    </div>
</div>
@endsection
