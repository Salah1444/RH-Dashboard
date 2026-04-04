<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title','RH-Dashboard') - Système RH</title>
<link rel="shortcut icon" href="{{ asset('images/rh-logo.png') }}" type="image/x-icon">
<!-- FontAwesome -->
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">


<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- DataTables -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<!-- CV Style -->
<link rel="stylesheet" href="{{ asset('css/cv.css') }}">
<!-- SB Admin -->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
@stack('styles')

</head>

<body id="page-top">

<div id="wrapper">

<x-main-sidebare/>

<div id="content-wrapper" class="d-flex flex-column">

<div id="content">

<x-main-nav/>

<div class="container-fluid">

@if(session('success'))
<div class="alert alert-success">
<i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
<i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

@yield('main')

</div>

</div>

<footer class="sticky-footer bg-white">
<div class="container my-auto">
<div class="text-center my-auto">
<span>Système RH © {{ date('Y') }}</span>
</div>
</div>
</footer>

</div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<!-- JS -->

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- SB Admin -->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

@stack('scripts')

</body>
</html>