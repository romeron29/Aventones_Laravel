<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas para invitados (Login y Registro)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/activate/{user}', [AuthController::class, 'activateAccount'])->name('activate.account');
    
});

// Rutas protegidas (Solo si está logueado)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Panel principal (Dashboard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
Route::resource('vehicles', VehicleController::class);
});