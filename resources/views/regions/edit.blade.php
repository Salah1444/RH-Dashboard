@extends('layouts.master')

@section('title', 'Modifier région')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Régions</a></li>
    <li class="breadcrumb-item active">{{ $region->LIB_REGION_FR }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit mr-2 text-warning"></i>Modifier : {{ $region->LIB_REGION_FR }}
    </h1>
    <a href="{{ route('regions.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('regions._form', ['action' => route('regions.update', $region->CD_REG), 'method' => 'PUT'])
@endsection
