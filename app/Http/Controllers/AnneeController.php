<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AnneesImport;

class AnneeController extends Controller
{
    public function index() {
        $tabAnnees = Annee::all();
        return view('affichage_elements.afficherAnnees', compact('tabAnnees'));
    }

    public function create(){
        return view('ajouts.ajoutAnnee');
    }

    public function store(Request $request){
        
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];

        $id = $request->input('adeb')."-".$request->input('afin');
        $request->merge(['id_annee'=>$id]);

        $validator =  $request ->validate([
            'adeb'=>['required','numeric','regex:/[0-9]{4}/'],
            'afin'=>['required','numeric','regex:/[0-9]{4}/','gt:adeb'],
            'id_annee' => 'required|unique:annees',
        ], $customErrorMessages);

        $annee = Annee::create([
            "id_annee" => $id,
            "annee_debut"=>$request->input('adeb'),
            "annee_fin"=>$request->input('afin')
        ]);

        return redirect()->route('annees.index')->withErrors($validator);
    }

    public function destroy(Request $request) {
        $_id_annee = $request->input("annee");
        $annee = Annee::findOrFail($_id_annee);
        foreach($annee->semestres as $semestre){
            //dd($semestre->id_semestre);
            //$semestre->oh(['semestre'=>$semestre->id_semestre]);
            $req = new Request(['semestre'=>$semestre->id_semestre]);
            app(SemestreController::class)->destroy($req);
        }
        $req = $annee->delete();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new AnneesImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successImportingYears', 'Les années ont été ajoutés avec succés');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }

}