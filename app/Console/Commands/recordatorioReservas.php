<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation; 
use App\Mail\PendingReservationReminder; 
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RecordatorioReservas extends Command
{
    protected $signature = 'recordatorioReservas {minutes=30}';
    protected $description = 'Identifica reservas pendientes sin respuesta por más de X minutos y notifica al chofer.';

    public function handle()
    {
        $minutes = (int) $this->argument('minutes');
        
        $timeLimit = Carbon::now()->subMinutes($minutes);

        // 1. Identificar las reservas
        $pendingReservations = Reservation::query()
            ->where('status', 'pendiente') 
            ->where('created_at', '<', $timeLimit) 
            ->with('ride.user') 
            ->get();

        // 2. Agrupar por Chofer
        $reservationsByDriver = $pendingReservations->groupBy('ride.user_id');

        $remindersSent = 0;

        foreach ($reservationsByDriver as $reservations) {
            $driver = $reservations->first()->ride->user;

            if ($driver && $driver->email) {
                
                // 3. Enviar el Mailable (Pasando las reservas y el tiempo límite)
                Mail::to($driver->email)->send(
                    new PendingReservationReminder($reservations, $minutes)
                );
                $remindersSent++;
            }
        }
        
        $this->info("Proceso de recordatorio completado. Se enviaron {$remindersSent} correos.");

        return 0;
    }
}