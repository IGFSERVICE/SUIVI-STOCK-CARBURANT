@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="icon fas fa-check"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="icon fas fa-ban"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="icon fas fa-exclamation-triangle"></i> {{ session('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="icon fas fa-info-circle"></i> {{ session('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
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
