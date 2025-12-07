@extends('layouts.app')
@section('title', 'Mis Vehículos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-car me-2"></i>Mis Vehículos</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm text-primary fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="fas fa-list-ul me-2"></i> Flota Registrada
            </h5>
            <a href="{{ route('vehicles.create') }}" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> Nuevo Vehículo
            </a>
        </div>
        <div class="card-body">
            @if($vehicles->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-car-crash fa-3x mb-3 opacity-50"></i>
                    <p class="fs-5">No tienes vehículos registrados aún.</p>
                    <p class="small">Agrega uno para poder empezar a publicar viajes.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Foto</th>
                                <th>Detalles</th>
                                <th>Placa</th>
                                <th>Capacidad</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $vehicle)
                            <tr>
                                <td>
                                    @if($vehicle->photo_path)
                                        <img src="{{ asset('storage/' . $vehicle->photo_path) }}" 
                                             class="rounded-3 shadow-sm" 
                                             width="60" height="60" 
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 60px; height: 60px;">
                                            <i class="fas fa-car fa-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-dark">{{ $vehicle->marca }} {{ $vehicle->modelo }}</strong>
                                    <br>
                                    <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $vehicle->year }} &bull; {{ $vehicle->color }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 font-monospace">{{ $vehicle->placa }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-users me-1"></i> {{ $vehicle->capacity }} Pasajeros
                                    </span>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm border-0 btn-eliminar" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
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

<script>
    document.querySelectorAll('.btn-eliminar').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: '¿Eliminar vehículo?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
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