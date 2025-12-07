@extends('layouts.app')
@section('title', 'Mis Reservas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-history me-2"></i>Historial de Reservas</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm text-primary fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="fas fa-ticket-alt me-2"></i> Viajes Confirmados
            </h5>
        </div>
        <div class="card-body">

            @if($reservations->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-ghost fa-3x mb-3"></i>
                    <p>No has reservado ningún viaje todavía.</p>
                    <a href="{{ route('rides.index') }}" class="btn btn-outline-primary mt-2">
                        <i class="fas fa-search me-1"></i> Buscar Rides
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Ruta</th>
                                <th>Chofer</th>
                                <th>Vehículo</th>
                                <th>Costo</th>
                                <th>Estado</th>
                                <th class="text-end">Acción</th> </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($reservation->ride->departure_time)->format('d M') }}
                                    </span><br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($reservation->ride->departure_time)->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $reservation->ride->origin }}</span>
                                    <i class="fas fa-arrow-right small text-muted mx-2"></i>
                                    <span class="fw-bold">{{ $reservation->ride->destination }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                            <i class="fas fa-user text-secondary small"></i>
                                        </div>
                                        <small>{{ $reservation->ride->user->name }}</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="d-block">{{ $reservation->ride->vehicle->marca }} {{ $reservation->ride->vehicle->modelo }}</small>
                                    <span class="badge bg-light text-dark border">{{ $reservation->ride->vehicle->placa }}</span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">₡ {{ number_format($reservation->ride->cost) }}</span>
                                </td>
                                <td>
                                    @if($reservation->status == 'pendiente')
                                        <span class="badge bg-warning text-dark shadow-sm">
                                            <i class="fas fa-clock me-1"></i> PENDIENTE
                                        </span>
                                    @elseif($reservation->status == 'aceptada')
                                        <span class="badge bg-success shadow-sm">
                                            <i class="fas fa-check-circle me-1"></i> ACEPTADA
                                        </span>
                                    @elseif($reservation->status == 'rechazada')
                                        <span class="badge bg-danger shadow-sm">
                                            <i class="fas fa-times-circle me-1"></i> RECHAZADA
                                        </span>
                                    @elseif($reservation->status == 'cancelada')
                                        <span class="badge bg-secondary shadow-sm">
                                            <i class="fas fa-ban me-1"></i> CANCELADA
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($reservation->status == 'pendiente' || $reservation->status == 'aceptada')
                                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que deseas cancelar tu lugar?')">
                                                <i class="fas fa-times me-1"></i> Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection