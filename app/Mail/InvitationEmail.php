<?php

namespace App\Mail;

use App\Models\Invitation; // Importer le modèle Invitation
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Invitation $invitation;

    /**
     * Créez une nouvelle instance de message.
     *
     * @param Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Obtenez l'enveloppe du message.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à rejoindre notre plateforme',
        );
    }

    /**
     * Définissez le contenu du message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: [
                'token' => $this->invitation->token,
                'email' => $this->invitation->email,
                'password' => $this->invitation->password]
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
