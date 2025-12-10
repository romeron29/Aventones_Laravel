@extends('layouts.app')
@section('title', 'Admin - Gestión de Usuarios')

@section('content')
<div class="container">
    <h1 class="text-primary fw-bold mb-5">Gestión de Usuarios y Tareas Administrativas</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <h3 class="mb-3 text-secondary" id="script-form"><i class="fas fa-robot me-2"></i> Ejecutar Tarea de Recordatorio</h3>
    <div class="card p-4 shadow-sm mb-5">
        <form action="{{ route('admin.runReminderScript') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-4">
                <label for="minutes" class="form-label">Minutos Mínimos a buscar</label>
                <input type="number" name="minutes" id="minutes" class="form-control @error('minutes') is-invalid @enderror" value="{{ old('minutes', 60) }}" min="1" required>
                @error('minutes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-8">
                <button type="submit" class="btn btn-warning fw-bold w-100">
                    <i class="fas fa-paper-plane me-2"></i> Ejecutar Script `recordatorioReservas`
                </button>
            </div>
            <p class="text-muted small mt-2">Este comando busca solicitudes de reserva que llevan más tiempo del especificado sin haber sido aceptadas o rechazadas.</p>
        </form>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-secondary"><i class="fas fa-users-cog me-2"></i> Control de Cuentas</h3>
        <a href="{{ route('admin.users.createAdminForm') }}" class="btn btn-success fw-bold">
            <i class="fas fa-user-plus me-2"></i> Crear Nuevo Administrador
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary text-uppercase">{{ $user->role }}</span></td>
                    <td>
                        @if($user->status == 'activo')
                            <span class="badge bg-success">Activo</span>
                        @elseif($user->status == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" 
                                class="btn btn-sm @if($user->status == 'activo') btn-outline-danger @else btn-outline-success @endif"
                                @if($user->role == 'admin' && $user->id == Auth::id()) disabled title="No puedes desactivar tu propia cuenta" @endif
                            >
                                @if($user->status == 'activo')
                                    Desactivar
                                @else
                                    Activar
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection