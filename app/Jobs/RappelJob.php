<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Rappel;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Mail;


class RappelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->checkAllNotesEval();
    }

    public function checkAllNotesByEvalId(Evaluation $eval){
        foreach($eval->eleves as $eleve) {
            if ($eleve->pivot->note == null){
                return False;
            }         
        }
        return True;
    }

    public function checkAllNotesEval(){
        $evals = Evaluation::all();
        foreach($evals as $eval) {
            $res = $this->checkAllNotesByEvalId($eval);
            $profs = $eval->ressource->professeur;
            syslog(1,"aaaaaa");
            foreach($profs as $prof) {
                $rappel = new Rappel($eval,$prof->utilisateur);
                //Mail::to($eval->ressource->professeur->utilisateur->email)->send($rappel);
                Mail::to("lucas.veslin@etu.iut-tlse3.fr")->send($rappel);
            }
            if ($res != False){
                
            }
        }
    }
}
