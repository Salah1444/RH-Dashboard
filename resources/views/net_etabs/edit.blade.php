@extends('layouts.master')

@section('title', 'Modifier réseau')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('net_etabs.index') }}">Réseaux</a></li>
    <li class="breadcrumb-item active">{{ $netEtab->LIBELLE_net_etab }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit mr-2 text-warning"></i>Modifier : {{ $netEtab->LIBELLE_net_etab }}
    </h1>
    <a href="{{ route('net_etabs.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('net_etabs._form', ['action' => route('net_etabs.update', $netEtab->CD_NETAB), 'method' => 'PUT'])
@endsection
