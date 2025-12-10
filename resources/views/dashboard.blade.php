@extends('layouts.app')
@section('title', 'Panel Principal')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-white p-4 shadow-sm border-start border-5 border-primary">
            <h2 class="text-primary fw-bold">¡Hola, {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">
                Bienvenido a Aventones. Actualmente estás conectado como:
                <span class="badge bg-secondary text-uppercase">{{ Auth::user()->role }}</span>
            </p>
        </div>
    </div>
    @if(Auth::user()->role == 'chofer' && isset($pending_reservations) && $pending_reservations->count() > 0)
    <div class="col-12 mb-4">
        <div class="card border-warning shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="fas fa-bell me-2"></i> Solicitudes Pendientes
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Pasajero</th>
                                <th>Para el viaje a...</th>
                                <th>Fecha</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pending_reservations as $req)
                            <tr>
                                <td class="fw-bold">
                                    <i class="fas fa-user-circle me-1 text-muted"></i>
                                    {{ $req->user->name }} {{ $req->user->lastname }}
                                </td>
                                <td>{{ $req->ride->destination }}</td>
                                <td>{{ \Carbon\Carbon::parse($req->ride->departure_time)->format('d/m H:i') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <form action="{{ route('reservations.approve', $req->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm fw-bold">
                                                <i class="fas fa-check"></i> Aceptar
                                            </button>
                                        </form>
                                        <form action="{{ route('reservations.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Rechazar pasajero?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row g-4">
        @if(Auth::user()->role == 'chofer')
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 hover-card">
                <div class="display-4 text-primary mb-3"><i class="fas fa-car"></i></div>
                <h5>Mis Vehículos</h5>
                <p class="text-muted small">Registra o edita tus autos.</p>
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">Gestionar</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 hover-card">
                <div class="display-4 text-success mb-3"><i class="fas fa-route"></i></div>
                <h5>Publicar Viaje</h5>
                <p class="text-muted small">Crea un nuevo aventón.</p>
                <a href="{{ route('rides.create') }}" class="btn btn-outline-success btn-sm rounded-pill">Crear Ride</a>
                <a href="{{ route('rides.my_rides') }}" class="d-block mt-2 small text-muted text-decoration-none">Ver mis publicados</a>
            </div>
        </div>
        @elseif(Auth::user()->role == 'pasajero')
        <div class="col-md-4">
            <div class="card h-100 text-center p-4">
                <div class="display-4 text-info mb-3"><i class="fas fa-search-location"></i></div>
                <h5>Buscar Ride</h5>
                <p class="text-muted small">Encuentra tu próximo viaje.</p>
                <a href="{{ route('rides.index') }}" class="btn btn-outline-info btn-sm rounded-pill">Buscar</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4">
                <div class="display-4 text-warning mb-3"><i class="fas fa-ticket-alt"></i></div>
                <h5>Mis Reservas</h5>
                <p class="text-muted small">Mira tus viajes pendientes.</p>
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-warning btn-sm rounded-pill">Ver Historial</a>
            </div>
        </div>
        @elseif(Auth::user()->role == 'admin')
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 border-start border-5 border-danger shadow-sm">
                <div class="display-4 text-danger mb-3"><i class="fas fa-user-shield"></i></div>
                <h5>Panel de Administración</h5>
                <p class="text-muted small">Acceso a la gestión de usuarios y sistema.</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger btn-sm rounded-pill">Ir al Panel</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection