@extends('layouts.app')

@section('main-content')
<div class="container">
    <h2>Tableau de bord</h2>
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-info-box title="Stock actuel" text="{{ $stock->quantite_actuelle ?? 0 }} litres" theme="info"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-info-box title="Nombre de chauffeurs" text="{{ $nombreChauffeurs }}" theme="success"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-info-box title="Nombre de véhicules" text="{{ $nombreVehicules }}" theme="warning"/>
        </div>
    </div>
</div>
@endsection
