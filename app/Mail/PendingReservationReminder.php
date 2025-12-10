<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PendingReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reservations;
    public $minutes;

    public function __construct(Collection $reservations, int $minutes)
    {
        $this->reservations = $reservations;
        $this->minutes = $minutes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio Urgente: Solicitudes de Reserva Pendientes',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pending-reservation-reminder', 
            with: [
                'count' => $this->reservations->count(),
                'driverName' => $this->reservations->first()->ride->user->name,
                'minutes' => $this->minutes,
            ],
        );
    }
}