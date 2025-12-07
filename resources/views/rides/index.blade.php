@extends('layouts.app')
@section('title', 'Buscar Viajes')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-search-location me-2"></i>Próximos Viajes</h2>

        <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm text-primary fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    @if($rides->isEmpty())
    <div class="alert alert-info text-center shadow">
        <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
        No hay viajes programados próximamente. ¡Vuelve más tarde!
    </div>
    @else
    <div class="row">
        @foreach($rides as $ride)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow border-0 hover-card">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary rounded-pill px-3">₡ {{ number_format($ride->cost) }}</span>
                        <small class="text-muted"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($ride->departure_time)->format('d M, h:i A') }}</small>
                    </div>
                </div>

                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">
                        {{ $ride->origin }} <i class="fas fa-arrow-right text-muted mx-2 small"></i> {{ $ride->destination }}
                    </h5>

                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-secondary"></i>
                        </div>
                        <div>
                            <small class="d-block text-muted" style="line-height: 1;">Chofer</small>
                            <span class="fw-bold small">{{ $ride->user->name }} {{ $ride->user->lastname }}</span>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted"><i class="fas fa-car me-1"></i> Vehículo</small>
                            <small class="fw-bold">{{ $ride->vehicle->marca }} {{ $ride->vehicle->modelo }}</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted"><i class="fas fa-chair me-1"></i> Asientos</small>
                            <small class="fw-bold {{ $ride->seats_available > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $ride->seats_available }} Disponibles
                            </small>
                        </div>
                    </div>

                    <div class="d-grid">
                        @if(Auth::user()->role == 'pasajero')

                        @php
                        // Busca la reserva específica de este usuario para este viaje
                        $miReserva = $ride->reservations->where('user_id', Auth::id())->first();
                        @endphp

                        @if($miReserva)
                        @if($miReserva->status == 'pendiente')
                        <button class="btn btn-warning fw-bold text-dark" disabled>
                            <i class="fas fa-clock me-2"></i> Pendiente de Aprobación
                        </button>
                        @elseif($miReserva->status == 'aceptada')
                        <button class="btn btn-secondary fw-bold" disabled>
                            <i class="fas fa-check-circle me-2"></i> Lugar Reservado
                        </button>
                        @elseif($miReserva->status == 'rechazada')
                        <button class="btn btn-danger fw-bold" disabled>
                            <i class="fas fa-times-circle me-2"></i> Solicitud Rechazada
                        </button>
                        @endif
                        @else
                        <form action="{{ route('reservations.store', $ride) }}" method="POST" class="form-reservar">
                            @csrf
                            <button type="button" class="btn btn-success fw-bold w-100 btn-reservar">
                                <i class="fas fa-ticket-alt me-2"></i> Solicitar Lugar
                            </button>
                        </form>
                        @endif

                        @elseif(Auth::id() == $ride->user_id)
                        <button class="btn btn-light text-muted border" disabled>Es tu viaje</button>
                        @else
                        <button class="btn btn-outline-primary" disabled>Solo pasajeros</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    document.querySelectorAll('.btn-reservar').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: '¿Confirmar reserva?',
                text: "Se descontará un campo disponible.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, reservar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            })
        });
    });
</script>
@endsection