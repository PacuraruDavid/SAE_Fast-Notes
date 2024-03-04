<?php

namespace App\Http\Controllers;

use App\Mail\Notif;
use App\Models\Evaluation;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class NotifController extends Controller
{
    public function envoyerEmail(Request $request)
{

    $idUtilisateur = $request->input('idUtilisateur');
    $idEvaluation = $request->input('idEvaluation');
    
    $utilisateur = Utilisateur::findOrFail($idUtilisateur);
    $evaluation = Evaluation::findOrFail($idEvaluation);
    //dd($evaluation->libelle);

    #$destinataire = $utilisateur->email;    
    $destinataire = Config::get('mail.to.address');

    $email = new Notif($evaluation, $utilisateur);

    Mail::to("lucas.thibaud@hotmail.com")->send($email);

    return 'Nice';
}

    public function getRouteMail(){
        return view('emails/email');
    }

}
