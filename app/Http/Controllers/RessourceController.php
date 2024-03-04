<?php

namespace App\Http\Controllers;

use App\Models\UE;
use Illuminate\Http\Request;
use App\Models\Ressource;
use DB;
use Excel;
use App\Imports\RessourceImport;

class RessourceController extends Controller
{
    public function index() {
        $tabRessources = Ressource::all();
        return view('affichage_elements.afficherRessources', compact('tabRessources'));
    }

    public function create(){
        $listeCompetences = UE::all();
        return view('ajouts.ajoutRessource', compact('listeCompetences'));
    }

    public function store(Request $request) {
        
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];

        $validator =  $request ->validate([
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
            'competence'=> 'required|string|max:255',
            'coef'=>'required|numeric|min:0|max:1'
        ]);

        $ressource = Ressource::create([
            'code' => $request->input('code'),
            'libelle' => $request->input('libelle')
        ]);
        $ue = UE::find($request->input('competence'));
        
        //"coefficient_ue", "code_ressource", "code_ue"
        $coef_UE = $ressource->ue()->attach($ue,[
            'code_ressource'=> $request->input('code'),
            'code_ue'=> $request->input('competence'),
            'coefficient'=> $request->input('coef')
        ]);

        return redirect()->route('ressource.index')->withErrors($validator);
    }

    public function destroy(Request $request) {
        $ressourceCode = $request->input('ressource');

        $ressource = Ressource::findOrFail($ressourceCode);

        $delEnseignements = DB::table('enseignements')
        ->where('code_ressource',$ressourceCode)
        ->delete();

        $delCoeff = DB::table('coefficient_ue')
        ->where('code_ressource', $ressourceCode)
        ->delete();

        $delRessourceGroupe = DB::table('ressource_groupe')
        ->where('code_ressource', $ressourceCode)
        ->delete();

        foreach($ressource->evaluations as $eval){
            $eval->destroy(['eval'=>$eval->id]);
        }

        $ressource->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new RessourceImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyRessources', 'Les ressources ont été ajoutées avec succès');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}