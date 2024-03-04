<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Imports\SemestreImport;
use Excel;

class SemestreController extends Controller
{
    public function index(){
        $tabSemestres = Semestre::all();
        
        return view('affichage_elements.afficherSemestres', compact('tabSemestres'));
    }

    public function create() {
        $listeAnnees = Annee::all();

        return view('ajouts.ajoutSemestre',compact('listeAnnees'));
    }

    public function store(Request $request) {
        
        $customErrorMessages = [
            'unique' => 'Le semestre existe déjà'
        ];

        $id_semestre = $request->numero . "_" . $request->annee;
        $request->merge(['id_semestre'=>$id_semestre]);

        $validator =  $request ->validate([
            'numero' => ['required', 'integer', 'between:1,6'],
            'annee' => [
                'required',
                'string',
                'regex:/^\d{4}-\d{4}$/',
            ],
            'id_semestre' => 'required|unique:semestres',
        ], $customErrorMessages
        );

        $annee_verif = Annee::findOrFail($request->input('annee'));

        $libelle = "Semestre " . $request->numero;

        $semestre = Semestre::create(['id_semestre'=>$id_semestre,
        'libelle'=>$libelle,
        'id_annee'=>$annee_verif->id_annee]);

        return redirect()->route('semestres.index')->withErrors($validator);

    }

    public function destroy(Request $request) {
        $_id_semestre = $request->input("semestre");
        $semestre = Semestre::findOrFail($_id_semestre);
        
        foreach($semestre->ue as $u){
            $u->id_semestre = null;
            $u->save();
        }
        foreach($semestre->parcours as $p){
            $req = new Request(['id'=>$p->id_parcour]);
            app(ParcoursController::class)->destroy($req);
        }

        $req = $semestre->delete();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new SemestreImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyRessources', 'Les ressources ont été ajoutées avec succès');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}
