<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $userName;
    public $token;
    public $role;
    /**
     * Create a new message instance.
     */
    public function __construct($userName, $token, $role)
    {
       
        $this->userName = $userName;
        $this->token = $token;
        $this->role = $role;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác thực tài khoản email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.verifyPassword',
            with: [
                'token'=> $this->token,
                'userName' => $this->userName,
                'role' => $this->role
            ]
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
