@extends('layouts.app')
@section('title', 'Ingresar')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sign-in-alt me-2"></i> Bienvenido de nuevo
            </div>
            <div class="card-body p-4">
                @if(session('success')) 
                    <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> {{ session('success') }}</div> 
                @endif
                @if($errors->any()) 
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}</div> 
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">
                            INGRESAR
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-white py-3 border-0">
                <small>¿No tienes cuenta? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #764ba2">Regístrate aquí</a></small>
            </div>
        </div>
    </div>
</div>
@endsection