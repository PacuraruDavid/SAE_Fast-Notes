<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class Demande extends Mailable
{
    use Queueable, SerializesModels;

    public $eleve;
    public $prof;
    public $eval;
    /**
     * Create a new message instance.
     */
    public function __construct($eleve, $prof, $evaluation)
    {
        $this->eleve = $eleve;
        $this->prof = $prof;
        $this->eval = $evaluation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nomEval = $this->eval->libelle;
        $prenom = $this->eleve->utilisateur->prenom;
        $nom = $this->eleve->utilisateur->nom;

        return new Envelope(
            subject: "Demande de consultation de copie de $prenom $nom en $nomEval",
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
        ->with(['libelle_eval' => $this->eval->libelle, 'prenom_eleve' => $this->eleve->utilisateur->prenom, 'email_eleve' => $this->eleve->utilisateur->email, 
                'nom_eleve' => $this->eleve->utilisateur->nom, 'prenom_prof' => $this->prof->utilisateur->prenom,
                'nom_prof' => $this->prof->utilisateur->nom])
        ->view('emails.demande_consultation')
        ->cc('nicolas.leymat@etu.iut-tlse3.fr');
    }

}
