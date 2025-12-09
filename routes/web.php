<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\ReservationController;

// --- PÁGINA DE INICIO (Landing Page) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- RUTAS PARA INVITADOS (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/activate/{user}', [AuthController::class, 'activateAccount'])->name('activate.account');
});

// --- RUTAS PROTEGIDAS (Solo Logueados) ---
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        $pending_reservations = [];
        if (Auth::user()->role == 'chofer') {
            $pending_reservations = \App\Models\Reservation::whereHas('ride', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('status', 'pendiente')->with('user', 'ride')->get();
        }
        return view('dashboard', compact('pending_reservations'));
    })->name('dashboard');
    // Rutas de Reservas (Pasajero)
    Route::post('/rides/{ride}/reserve', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');

    // Rutas de Aprobación (Chofer)
    Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    // Ruta para cancelar reserva (Pasajero)
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    // Ruta para ver mis viajes publicados (Chofer)
    Route::get('/my-published-rides', [RideController::class, 'myRides'])->name('rides.my_rides');
});
Route::middleware(['auth', 'role:chofer'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::get('/my-published-rides', [RideController::class, 'myRides'])->name('rides.myRides');
    Route::delete('/rides/{ride}', [RideController::class, 'destroy'])->name('rides.destroy');
    }
);