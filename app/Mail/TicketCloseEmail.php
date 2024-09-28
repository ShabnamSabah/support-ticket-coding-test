<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCloseEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public  $sub;
    public $senderEmail;
    public $senderName;
    public $receiverName;
    /**
     * Create a new message instance.
     */
    public function __construct($msg, $subject, $senderEmail, $senderName, $receiverName)
    {
        $this->msg = $msg;
        $this->sub = $subject;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->senderEmail, $this->senderName),
            subject:  $this->sub,
            
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.customer.pages.email',
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
