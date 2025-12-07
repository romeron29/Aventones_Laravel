@extends('layouts.app')
@section('title', 'Panel Principal')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-white p-4 shadow-sm border-start border-5 border-primary">
            <h2 class="text-primary fw-bold">¡Hola, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-muted mb-0">
                Bienvenido a Aventones. Actualmente estás conectado como: 
                <span class="badge bg-secondary text-uppercase">{{ Auth::user()->role }}</span>
            </p>
        </div>
    </div>

    <div class="row g-4">
        @if(Auth::user()->role == 'chofer')
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 text-primary mb-3"><i class="fas fa-car"></i></div>
                    <h5>Mis Vehículos</h5>
                    <p class="text-muted small">Registra o edita tus autos.</p>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">Gestionar</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 text-success mb-3"><i class="fas fa-route"></i></div>
                    <h5>Publicar Viaje</h5>
                    <p class="text-muted small">Crea un nuevo aventón.</p>
                    <a href="#" class="btn btn-outline-success btn-sm rounded-pill">Crear Ride</a>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="display-4 text-info mb-3"><i class="fas fa-search-location"></i></div>
                    <h5>Buscar Ride</h5>
                    <p class="text-muted small">Encuentra tu próximo viaje.</p>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-pill">Buscar</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection