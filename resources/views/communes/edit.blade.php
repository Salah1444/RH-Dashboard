@extends('layouts.master')

@section('title', 'Modifier commune')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('communes.index') }}">Communes</a></li>
    <li class="breadcrumb-item active">{{ $commune->LIB_COMMUNE_FR }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit mr-2 text-warning"></i>Modifier : {{ $commune->LIB_COMMUNE_FR }}
    </h1>
    <a href="{{ route('communes.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('communes._form', ['action' => route('communes.update', $commune->CD_COM), 'method' => 'PUT'])
@endsection
