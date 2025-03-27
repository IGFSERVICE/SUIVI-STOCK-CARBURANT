@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center text-primary">📊 Consommation de Carburant</h2>

    <!-- Formulaire de filtre -->
    <div class="card shadow p-4 mb-4">
        <form method="GET" action="{{ route('approvisionnements.consommation') }}">
            <div class="row">
                <div class="col-md-5">
                    <label for="date_debut"><strong>📅 Date début :</strong></label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-5">
                    <label for="date_fin"><strong>📅 Date fin :</strong></label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Graphique -->
    <div class="card shadow p-4">
        <canvas id="consommationChart"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("consommationChart").getContext("2d");
        var consommationChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: "Consommation de carburant (L)",
                    data: {!! json_encode($data) !!},
                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endsection
