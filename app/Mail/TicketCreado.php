<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $usuario;

    public function __construct($ticket, $usuario)
    {
        $this->ticket = $ticket;
        $this->usuario = $usuario;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Creado Exitosamente - ' . $this->ticket->codigo_ticket,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-creado',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
