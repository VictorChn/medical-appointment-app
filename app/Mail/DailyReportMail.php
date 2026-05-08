<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
    public $role;
    public $appointments;

    /**
     * Create a new message instance.
     */
    public function __construct(string $recipientName, string $role, Collection $appointments)
    {
        $this->recipientName = $recipientName;
        $this->role = $role;
        $this->appointments = $appointments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $roleTitle = $this->role === 'admin' ? 'Administrador' : 'Doctor';
        return new Envelope(
            subject: "Resumen Diario de Citas - {$roleTitle} - " . now()->format('d/m/Y'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
