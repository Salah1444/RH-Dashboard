@extends('layouts.master')

@section('title', "Nouveau réseau d'établissements")

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('net_etabs.index') }}">Réseaux</a></li>
    <li class="breadcrumb-item active">Nouveau réseau</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus-circle mr-2 text-primary"></i>Nouveau réseau d'établissements
    </h1>
    <a href="{{ route('net_etabs.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('net_etabs._form', ['netEtab' => null, 'action' => route('net_etabs.store'), 'method' => 'POST'])
@endsection
