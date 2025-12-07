@extends('layouts.app')
@section('title', 'Crear Cuenta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-2"></i> Únete a Aventones
            </div>
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Apellido</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Cédula</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nacimiento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <label class="form-label small text-muted">Rol</label>
                             <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-users"></i></span>
                                <select name="role" class="form-select">
                                    <option value="pasajero" {{ old('role') == 'pasajero' ? 'selected' : '' }}>Pasajero</option>
                                    <option value="chofer" {{ old('role') == 'chofer' ? 'selected' : '' }}>Chofer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Confirmar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                            REGISTRARSE <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-white py-3 border-0">
                <small>¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #764ba2">Ingresa aquí</a></small>
            </div>
        </div>
    </div>
</div>
@endsection