@extends('layouts.app')
@section('title', 'Bienvenido')

@section('content')
<div class="row align-items-center justify-content-center text-center" style="min-height: 70vh;">
    <div class="col-md-8 text-white">
        
        <div class="mb-4 animate-bounce">
            <i class="fas fa-car-side fa-6x text-white opacity-75"></i>
        </div>

        <h1 class="display-3 fw-bold mb-3">Aventones</h1>
        <p class="lead fs-4 mb-5 opacity-75">
            Viaja cómodo, seguro y en equipo. <br>
            La mejor forma de coordinar el transporte corporativo.
        </p>

        <div class="d-flex justify-content-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-bold text-primary shadow">
                    <i class="fas fa-tachometer-alt me-2"></i> Ir al Panel
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 fw-bold text-primary shadow">
                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                </a>
                
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 fw-bold">
                    <i class="fas fa-user-plus me-2"></i> Registrarse
                </a>
            @endauth
        </div>

        <div class="mt-5 pt-5 opacity-50 small">
            &copy; {{ date('Y') }} Sistema de Aventones Corporativos.
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .fa-car-side {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endsection