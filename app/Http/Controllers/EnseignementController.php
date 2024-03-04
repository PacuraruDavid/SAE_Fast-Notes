<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignement;
use App\Models\Professeur;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EnseignementsImport;
use DB;

class EnseignementController extends Controller
{
    public function index() {
        $tabEnseignements = Enseignement::all();
        
        return view('affichage_elements.afficherEnseignements', compact('tabEnseignements'));
    }

    public function ajouterEnseignements (Request $request) {
        $ressources = $request->input('ressource', []);
        $groupes = $request->input('groupe',[]);
        $prof = Professeur::findOrFail($request->input('professeur'));

        $customErrorMessages = [
            'exists' => "Ce :attribute n'existe pas"
        ];

        $validator =  $request ->validate([
            'groupe'=> 'required|exists:groupes,id',
            'professeur'=>'required|exists:professeurs,code',
            'ressource' => [
                'required',
                Rule::unique('enseignements',"code_ressource")->where(function ($query) use ($request) {
                    return $query->where('id_groupe', $request->input('groupe'))
                        ->where('code_prof', $request->input('professeur'))
                        ->where('code_ressource', $request->input('ressource'));
                }),
            ],
            
        ]
        );



        foreach ($ressources as $index=>$ressource) {
            if (isset ($groupes[$index])) {
                Enseignement::create(["code_prof"=>$request->input('professeur'),
                "id_groupe"=>$groupes[$index],
                "code_ressource"=>$ressource]);
            }
        }

        return redirect()->back()->withErrors($validator);
    }

    public function destroy(Request $request) {
        $profId = $request->input('prof');
        $groupeId = $request->input('groupe');
        $ressourceCode = $request->input('ressource');


        $req = DB::table('enseignements')
        ->where('code_prof',$profId)
        ->where('id_groupe', $groupeId)
        ->where('code_ressource', $ressourceCode)
        ->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new EnseignementsImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successImportingEnseignements', 'Les enseignements ont été ajoutés avec succés');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}