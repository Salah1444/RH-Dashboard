@extends('layouts.master')

@section('title', 'Nouvelle commune')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('communes.index') }}">Communes</a></li>
    <li class="breadcrumb-item active">Nouvelle commune</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus-circle mr-2 text-primary"></i>Nouvelle commune
    </h1>
    <a href="{{ route('communes.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour
    </a>
</div>

@include('communes._form', ['commune' => null, 'action' => route('communes.store'), 'method' => 'POST'])
@endsection
