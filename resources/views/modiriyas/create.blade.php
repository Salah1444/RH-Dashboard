@extends('layouts.master')

@section('title', 'Nouvelle modiriya')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('modiriyas.index') }}">Modiriyas</a></li>
    <li class="breadcrumb-item active">Nouvelle modiriya</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus-circle mr-2 text-primary"></i>Nouvelle modiriya
    </h1>
    <a href="{{ route('modiriyas.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('modiriyas._form', ['modiriya' => null, 'action' => route('modiriyas.store'), 'method' => 'POST'])
@endsection
