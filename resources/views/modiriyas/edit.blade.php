@extends('layouts.master')

@section('title', 'Modifier modiriya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('modiriyas.index') }}">Modiriyas</a></li>
    <li class="breadcrumb-item active">{{ $modiriya->nom_modiriya }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit mr-2 text-warning"></i>Modifier : {{ $modiriya->nom_modiriya }}
    </h1>
    <a href="{{ route('modiriyas.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('modiriyas._form', ['action' => route('modiriyas.update', $modiriya->modiriya_id), 'method' => 'PUT'])
@endsection
