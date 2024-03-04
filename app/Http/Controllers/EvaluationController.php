<?php

namespace App\Http\Controllers;

use App\Imports\EvaluationImport;
use App\Models\Eleve;
use App\Models\Enseignement;
use App\Models\Evaluation;
use App\Mail\Notif;
use App\Models\Groupe;
use App\Models\Professeur;
use App\Models\Ressource;
use Illuminate\Support\Facades\Mail;
use Auth;
use BoxPlot;
use DB;
use Graph;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Runner\GarbageCollection\GarbageCollectionHandler;
use App\Mail\Rappel;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $results = DB::table('evaluations')->get()->sortBy('libelle');
        if (Gate::allows('isAdmin')) {
            $ressources = Ressource::all();
        }
        else {
            $user = Professeur::findOrFail(Auth::user()->code);
            $ressources = $user->ressource->unique();
        }
        $results = [];
        foreach ($ressources as $ressource){
            $evals = DB::table('evaluations')->distinct()->where('code_ressource',$ressource->code)->get();
            foreach($evals as $eval){
                array_push($results, $eval);
            }
        }
        return view('dashboards.dashprof')->with('evals', $results);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $listeRessources = Ressource::all();

        return view('ajouts.ajoutEval',compact('listeRessources'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques'
        ];
        

        $validator =  $request ->validate([
            'libelle' => 'required|string|max:255',
            'coefficient' => 'required|decimal:1',
            'type' => 'required|string|max:255',
            'date_epreuve' => 'nullable|date|after:yesterday',
            'date_rattrapage'=>'nullable|date|after:date_epreuve',
            'ressource'=>'required|string|max:255'],$customErrorMessages
        );

        $eval = Evaluation::create (['libelle'=>$request->input("libelle"),
        'coefficient'=>$request->input("coefficient"),
        'type'=>$request->input('type'),
        'date_epreuve'=>$request->input('date_epreuve'),
        'date_rattrapage'=>$request->input('date_rattrapage'),
        'code_ressource'=>$request->input('ressource')]);

        return redirect()->route('evaluations')->withErrors($validator);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idEval)
    {
        $stats = $this->boxPlot($idEval);
        $evaluation = Evaluation::findOrFail($idEval);
        $eleves = [];
        $code_user = Auth::user()->code;
        $eleves_prof = [];
        
        $this->getNotes($idEval, $code_user);
        $groupes=[];

        $ressourceEval = $evaluation->ressource; 

        if (! empty($ressourceEval) ) {        
            $ratio = 0;
            foreach($ressourceEval->groupe as $groupe_prof){
                
                if($groupe_prof->pivot->code_prof == $code_user) {
                    $ratio +=1;
                    array_push($eleves_prof, $groupe_prof->eleves);
                }
            }
            foreach($eleves_prof as $eleve_prof){
                foreach($eleve_prof as $eleve_prof){
                    array_push($groupes, $eleve_prof->id_groupe);
                    $pivotData = $eleve_prof
                    ->evaluations()
                    ->where('id_evaluation', $idEval)->first();
        
                    if ($pivotData) {
                        $note = $pivotData->pivot->note;
                    } else {
                        $note = '';
                    }
                    
                    $infosEleve = ['nom'=>$eleve_prof->utilisateur->nom, 'identification'=>$eleve_prof->identification, 'prenom'=>$eleve_prof->utilisateur->prenom,'id_groupe'=>$eleve_prof->id_groupe, 'note'=>$note,'code'=>$eleve_prof->code];
                    
                    array_push($eleves, $infosEleve);
                }
            }
            $groupe= array_unique($groupes);
        }
        return view('notes.evaluation',compact('evaluation','eleves','groupe'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function saisirNote (string $idEval, string $idEleve, float $note) {

        if (!Gate::allows('isProf')){
            abort(403, Gate::allows('Vous n\'êtes pas prof'));
        }

        $evaluation = Evaluation::findOrFail($idEval);
        $eleve = Eleve::findOrFail($idEleve);


        if ($note >=0 && $note <=20 && $evaluation && $eleve) {

            $exists =  $evaluation->eleves()->wherePivot('code_eleve', $idEleve)->exists();
            if ($exists) {
                $oldnote =  $evaluation->eleves()->wherePivot('code_eleve', $idEleve)->first()->pivot->note;
            }
            if (!$exists || $oldnote != $note ) {
                $evaluation->eleves()->syncWithoutDetaching([
                $idEleve => ['note' => $note]]);
                if ($eleve->utilisateur->notifications) {
                    $notif = new Notif($evaluation,$eleve->utilisateur,$note);
                    Mail::to($eleve->utilisateur->email)->send($notif);
                }
        }
    }
    }

    public function saisirNotes (Request $request) {
        
        if (!Gate::allows('isProf')){
            abort(403, Gate::allows('Vous n\'êtes pas prof'));
        }

        $evalId =$request->input('evaluation_id');
        $notes = $request->input('notes');
        foreach ($notes as $eleveID => $note) {
            //return $note;
            
            if ($note["note"] != null) {
                
                $this->saisirNote($evalId,$eleveID,$note["note"]);
            }

        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $evalId = $request->input('eval');

        $eval = Evaluation::findOrFail($evalId);

        $req = DB::table('note_evaluation')
        ->where('id_evaluation', $evalId)
        ->delete();

        $eval->delete();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function boxPlot($idEval){
        $notes = $this->getNotes($idEval, 'a');
        sort($notes);
        $len = count($notes);
        if ($len == 0) {
            $mediane = 0;
            $pQuartile = 0;
            $tQuartile = 0;
            $firstNote = 0;
        }
        else { 
            if ($len%2 == 1) {
                $rangMediane = ($len+1)/2;
                $rangPQuartile = ($rangMediane)/2;
                $rangTQuartile = $rangMediane+($rangMediane)/2;
                $mediane = $notes[$rangMediane-1];
                $pQuartile = $notes[$rangPQuartile-1];
                $tQuartile = $notes[$rangTQuartile-1];
            } 
            else {
                $rangMediane = $len/2;
                $rangPQuartile = $rangMediane/2;
                $rangTQuartile = $rangMediane+($rangMediane/2);
                $mediane = ($notes[$rangMediane-1]+$notes[$rangMediane])/2;
                $pQuartile = ($notes[$rangPQuartile-1]+$notes[$rangPQuartile])/2;
                $tQuartile = ($notes[$rangTQuartile-1]+$notes[$rangTQuartile])/2;
        }
        $firstNote = $notes[0];
    }
        $stats = array($pQuartile, $tQuartile, $firstNote, end($notes), $mediane,$pQuartile, $tQuartile, $firstNote, end($notes), $mediane);

        require_once(base_path().'\libraries\jpgraph\src\jpgraph.php');
        require_once (base_path().'\libraries\jpgraph\src\jpgraph_stock.php');

        // Setup a simple graph
        $graph = new Graph(250,200);
        $graph->SetScale('textlin',0,20.2);
        $graph->SetMarginColor('lightblue');
        $graph->xaxis->SetColor('white');
        $graph->title->Set('Notes de l\'évaluation');

        // Create a new stock plot
        $p1 = new BoxPlot($stats,array(0.5,0.5));
        
        // Width of the bars (in pixels)
        $p1->SetWidth(9);
        
        
        // Add the plot to the graph and send it back to the browser
        $graph->Add($p1);
        if(file_exists(public_path().'\images\graph'.$idEval.'.jpg')) {
            unlink(public_path().'\images\graph'.$idEval.'.jpg');
        }
        $graph->Stroke(public_path().'\images\graph'.$idEval.'.jpg');
        return $this->moyenne_ecart_type($idEval);
        
        

    }

    public function getNotes(string $idEval, string $idProf){
        $eval = Evaluation::findOrFail($idEval);
        $notes = [];
        foreach($eval->eleves as $eleve) {
            array_push($notes, $eleve->pivot->note);            
        }
        return $notes;
    }

    function moyenne_ecart_type(string $idEval) {
        $notes = $this->getNotes($idEval, Auth::user()->code);
        if (count($notes) == 0) {
            $moyenne = "Non disponible";
        }
        else {
        $moyenne = array_sum($notes)/count($notes);
        }
        $fVariance = 0.0;
        foreach ($notes as $i) {
            $fVariance += pow($i - $moyenne, 2);
        }     
        $size = count($notes) - 1;
        $res = [];
        $res['moyenne'] = round($moyenne, 2);
        if ($size == 0){
            $res['ecart_type'] = 0;
        } else {
            $res['ecart_type'] = round((float) sqrt($fVariance)/sqrt($size),3);
        }
        return $res;
    }

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new EvaluationImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyEvaluations', 'Les évaluations ont été ajoutées avec succès');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }

    public function checkAllNotesByEvalId(Evaluation $eval, Groupe $groupe){
        foreach($groupe->eleves as $eleve) {
            $dateEval1 = Carbon::parse($eval->date_epreuve);
            $dateEval2 = Carbon::parse($eval->date_epreuve);
            $dateNow = Carbon::now();
            $dateEval1->addDays(15);
            $dateEval2->addMonth();
            $dateEval2->subDays(7);
            //
            Log::info($dateEval1);
            Log::info($dateNow);
            Log::info($eval->libelle);
            if ($dateEval1->isSameDay($dateNow) || $dateEval2->isSameDay($dateNow)){
                Log::info('c bon');
                $prof =  $eleve->evaluations->find($eval->id);
                Log::info($prof);
                if ($prof === null){
                    return False;
                }
                $note = optional($prof->pivot)->note;
                if ($note === null){
                    return False;
                } 
            }        
        }
        return True;
    }

    public function checkAllNotesEval(){
        $evals = Evaluation::all();
        foreach($evals as $eval) {
            $groupes = $eval->ressource->groupe;
            foreach($groupes as $groupe) {
                Log::info("check");
                $res = $this->checkAllNotesByEvalId($eval, $groupe);
                if ($res == False){
                    Log::info("ça arrive fort");
                    $prof = Professeur::find($groupe->pivot->code_prof);
                    $rappel = new Rappel($eval,$prof->utilisateur, $groupe);
                    Mail::to($prof->utilisateur->email)->send($rappel);
                }
            }
        }
    }

    public function afficherEvals(){
        $tabEvals = Evaluation::all();
        return view('affichage_elements.afficherEvals', compact('tabEvals'));
    }

    public function showStats(string $idEval){
        $stats = $this->boxPlot($idEval);
        $evaluation = Evaluation::find($idEval);
        return view('notes.stats',compact('stats','evaluation'));
    }
}
