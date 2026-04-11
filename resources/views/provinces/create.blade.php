@extends('layouts.master')

@section('title', 'Nouvelle province')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('provinces.index') }}">Provinces</a></li>
    <li class="breadcrumb-item active">Nouvelle province</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus-circle mr-2 text-primary"></i>Nouvelle province
    </h1>
    <a href="{{ route('provinces.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('provinces._form', ['province' => null, 'action' => route('provinces.store'), 'method' => 'POST'])
@endsection
