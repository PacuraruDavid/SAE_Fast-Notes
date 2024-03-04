<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semestre;
use App\Models\Groupe;
use App\Models\Parcours;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParcoursImport;

class ParcoursController extends Controller
{
    public function index() {
        $tabParcours = Parcours::all();
        $listeSemestres = [];
        foreach ($tabParcours as $parcours) {
            array_push($listeSemestres,$parcours->semestre);
            
        }
        return view('affichage_elements.afficherParcours', compact('tabParcours','listeSemestres'));
    }

    public function create() {
        $listeSemestres = Semestre::all();

        return view('ajouts.ajoutParcours',compact('listeSemestres'));
    }

    public function store(Request $request){

        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];

        $validator =  $request ->validate([
            'id' => 'required|string|max:255',
            'semestre'=>'required|string|max:255'],
            $customErrorMessages
        );

        $parcours = Parcours::create(['id_parcour' => $request->input('id'), 'id_semestre' => $request->input('semestre')]);

        return redirect()->route('parcours.index')->withErrors($validator);
    }

    public function destroy(Request $request) {
        $parcoursId = $request->input('id');

        $listeGroupesAssocies = [];
        $listeGroupesAssocies = DB::table('groupes')->where('parcours', $parcoursId)->get();

        foreach($listeGroupesAssocies as $groupeAssocie) {
            $groupe = Groupe::findOrFail($groupeAssocie->id);
            $groupe->parcours = null;
            $groupe->save();
        }

        $req = DB::table('parcours')
        ->where('id_parcour',$parcoursId)
        ->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new ParcoursImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successImportingParcours', 'Les parcours ont été ajoutés avec succés');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}