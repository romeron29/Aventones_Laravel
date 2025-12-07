<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationRequestMail;
use App\Mail\ReservationAcceptedMail; 

class ReservationController extends Controller
{
    // 1. SOLICITAR RESERVA 
    public function store(Request $request, Ride $ride)
    {
        if (Auth::user()->role !== 'pasajero') {
            return back()->with('error', 'Solo los pasajeros pueden reservar.');
        }

       
        if ($ride->seats_available < 1) {
            return back()->with('error', 'No hay espacio disponible.');
        }

        $existing = Reservation::where('user_id', Auth::id())->where('ride_id', $ride->id)->first();
        if ($existing) {
            return back()->with('error', 'Ya tienes una solicitud para este viaje.');
        }

        // CREAR CON ESTADO PENDIENTE
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'ride_id' => $ride->id,
            'status'  => 'pendiente' 
        ]);

        // ENVIAR CORREO AL CHOFER (Solicitud)
        try {
            Mail::to($ride->user->email)->send(new ReservationRequestMail($reservation));
        } catch (\Exception $e) {
            // Si falla el correo, seguimos igual
        }

        return back()->with('success', 'Solicitud enviada. Espera a que el chofer te acepte.');
    }

    // 2. ACEPTAR SOLICITUD (Solo Chofer)
    public function approve(Reservation $reservation)
    {
        if (Auth::id() !== $reservation->ride->user_id) {
            abort(403);
        }

        if ($reservation->ride->seats_available < 1) {
            return back()->with('error', 'Ya no quedan asientos para aceptar esta solicitud.');
        }


        $reservation->update(['status' => 'aceptada']);
        $reservation->ride->decrement('seats_available');


        try {
            Mail::to($reservation->user->email)->send(new ReservationAcceptedMail($reservation));
        } catch (\Exception $e) {

        }

        return back()->with('success', 'Pasajero aceptado y notificación enviada.');
    }

    // 3. RECHAZAR SOLICITUD 
    public function reject(Reservation $reservation)
    {
        if (Auth::id() !== $reservation->ride->user_id) {
            abort(403);
        }

        $reservation->update(['status' => 'rechazada']);

        return back()->with('success', 'Solicitud rechazada.');
    }

    // Ver mis reservas (Pasajero)
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        $reservations = $user->reservations()->with(['ride.user', 'ride.vehicle'])->get();

        return view('reservations.index', compact('reservations'));
    }

    // Cancelar mi propia reserva (Pasajero)
    public function cancel(Reservation $reservation)
    {

        if (Auth::id() !== $reservation->user_id) {
            abort(403);
        }

        if ($reservation->status == 'cancelada') {
            return back();
        }

        // Si estaba aceptada, devolvemos el cupo al viaje
        if ($reservation->status == 'aceptada') {
            $reservation->ride->increment('seats_available');
        }

        // Cambiamos estado a cancelada
        $reservation->update(['status' => 'cancelada']);

        return back()->with('success', 'Has cancelado tu reserva.');
    }
}