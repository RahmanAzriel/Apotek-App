@extends('layouts.layout')

@section('content')
@if (Session::get('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="z-index: 1050; position: relative;">
        {{ Session::get('failed') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6f42c1;">
    <div class="container">
        <a class="navbar-brand" href="#">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Fullscreen Background -->
<div class="container-fluid d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(to bottom right, #6f42c1, #007bff); height: calc(100vh - 56px); width: 100vw; position: absolute; top: 56px; left: 0;">
    <div class="text-center p-5" style="max-width: 600px; color: white;">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="lead mb-4" style="font-size: 1.2rem;">
            Rasakan kemudahan dengan antarmuka yang rapi dan intuitif.
        </p>
        <div class="mb-4">
            <i class="fas fa-user-check fa-4x text-primary"></i>
        </div>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="#" class="btn btn-primary btn-lg rounded-pill shadow-sm" style="padding: 0.75rem 2rem;">
                Mulai
            </a>
            <a href="#" class="btn btn-outline-light btn-lg rounded-pill shadow-sm" style="padding: 0.75rem 2rem;" onclick="handleInfoClick()">
                Info
            </a>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        height: 100vh; /* Ensures the body takes full height */
        overflow: hidden; /* Prevents scrolling */
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline-light {
        border: 2px solid #ffffff;
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    h1 {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .lead {
        font-weight: 400;
        line-height: 1.5;
    }
</style>

<script>
    function handleInfoClick() {
        // Add your logic here for the info button
        alert('Info button clicked!');
    }
</script>
@endsection
