<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCambioEstado extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $usuario;
    public $estadoAnterior;
    public $estadoNuevo;

    public function __construct($ticket, $usuario, $estadoAnterior, $estadoNuevo)
    {
        $this->ticket = $ticket;
        $this->usuario = $usuario;
        $this->estadoAnterior = $estadoAnterior;
        $this->estadoNuevo = $estadoNuevo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización de Ticket - ' . $this->ticket->codigo_ticket,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-cambio-estado',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
