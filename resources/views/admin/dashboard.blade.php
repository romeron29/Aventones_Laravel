@extends('layouts.app')
@section('title', 'Admin - Panel Principal')

@section('content')
<div class="container">
    <h1 class="text-primary fw-bold mb-4">Panel de Administración</h1>
    <p class="lead">Bienvenido, {{ Auth::user()->name }}. Acceso completo a las herramientas de gestión del sistema.</p>
    
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card p-4 shadow-sm h-100 border-start border-5 border-success">
                <div class="display-4 text-success mb-3"><i class="fas fa-users-cog"></i></div>
                <h5>Gestión de Usuarios</h5>
                <p class="text-muted small">Activar, desactivar y crear administradores.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-success mt-auto">Ir a Usuarios</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card p-4 shadow-sm h-100 border-start border-5 border-warning">
                <div class="display-4 text-warning mb-3"><i class="fas fa-robot"></i></div>
                <h5>Tareas de Sistema</h5>
                <p class="text-muted small">Ejecutar el script de recordatorio de reservas pendientes.</p>
                <a href="{{ route('admin.users.index') }}#script-form" class="btn btn-sm btn-outline-warning mt-auto">Ejecutar Script</a>
            </div>
        </div>
        
    </div>
</div>
@endsection