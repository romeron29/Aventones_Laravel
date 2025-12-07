@extends('layouts.app')
@section('title', 'Publicar Viaje')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-route me-2"></i>Publicar Nuevo Viaje</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm text-primary fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-success fw-bold">
                        <i class="fas fa-pen-alt me-2"></i> Detalles del Aventón
                    </h5>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error) 
                                    <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li> 
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('rides.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 p-3 bg-light rounded border">
                            <label class="form-label fw-bold text-dark mb-2">1. Selecciona tu Vehículo</label>
                            <select name="vehicle_id" class="form-select form-select-lg border-0 shadow-sm" required>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
                                        {{ $vehicle->marca }} {{ $vehicle->modelo }} ({{ $vehicle->placa }}) - {{ $vehicle->capacity }} Pasajeros
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> Solo aparecen tus vehículos registrados.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">2. Define la Ruta</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Origen</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-danger"></i></span>
                                        <input type="text" name="origin" class="form-control" placeholder="Ej: Oficinas Centrales" value="{{ old('origin') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Destino</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-flag-checkered text-success"></i></span>
                                        <input type="text" name="destination" class="form-control" placeholder="Ej: Cartago Centro" value="{{ old('destination') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">3. Horario y Costo</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Fecha y Hora</label>
                                    <input type="datetime-local" name="departure_time" class="form-control" value="{{ old('departure_time') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Costo por persona</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white fw-bold">₡</span>
                                        <input type="number" name="cost" class="form-control" placeholder="2000" min="0" value="{{ old('cost') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Asientos Disponibles</label>
                                    <input type="number" name="seats_available" class="form-control" placeholder="3" min="1" value="{{ old('seats_available') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-success py-2 fw-bold shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> PUBLICAR VIAJE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection