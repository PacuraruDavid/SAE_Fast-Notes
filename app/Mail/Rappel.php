<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class Rappel extends Mailable
{
    use Queueable, SerializesModels;

    public $eval;
    public $user;
    public $groupe;
    /**
     * Create a new message instance.
     */
    public function __construct($evaluation, $utilisateur, $groupe)
    {
        $this->eval = $evaluation;
        $this->user = $utilisateur;
        $this->groupe = $groupe;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $libelleEval = $this->eval->libelle;

        return new Envelope(
            subject: "Attention, il faut mettre les notes pour l'evaluation $libelleEval",
        );
    }

    /**
     * Get the message content definition.
     */
    /**public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this
        ->with(['libelle_eval' => $this->eval->libelle, 'prenom' => $this->user->prenom, 'nom' => $this->user->nom, 
        'nom_groupe' => $this->groupe->libelle])
        ->view('emails.rappel_note')
        ->cc('lucas.veslin@etu.iut-tlse3.fr');
    }

}
