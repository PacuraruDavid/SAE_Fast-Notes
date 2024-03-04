<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UE;
use App\Models\Semestre;
use App\Models\Competence;
use App\Imports\UEImport;
use Excel;

class UEController extends Controller
{
    public function index(){
        $tabUE = UE::all();
        $listeCompetences = [];
        $listeSemestres = [];
        foreach ($tabUE as $UE) {
            array_push($listeCompetences,$UE->competence) ;
            array_push($listeSemestres,$UE->semestre);
        }
        return view('affichage_elements.listeUE', compact('tabUE','listeCompetences','listeSemestres'));
    }

    public function create() {
        $listeSemestres = Semestre::all();
        $listeCompetences = Competence::all();

        return view('ajouts.ajoutUE',compact('listeSemestres','listeCompetences'));
    }

    public function store(Request $request) {
        
        $validator =  $request ->validate([
            'code' => 'required|string|max:255|unique:ue',
            'libelle' => 'required|string|max:255',
            'competence'=>'required|string|max:255',
            'semestre'=>'required|string|max:255']
        );

        $competence = Competence::findOrFail($request->input('competence'));
        

        $semestre = Semestre::findOrFail($request->input("semestre"));


        $ue = UE::create(['libelle'=>$request->input('libelle'),
        'code'=>$request->input('code'),
        'code_competence'=>$competence->code,
        'id_semestre'=>$semestre->id_semestre]);

        return redirect()->route('ue.index')->withErrors($validator);
    }

    public function destroy(UE $ue) {
        
        $ue->ressources()->detach();

        $ue->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new UEImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyRessources', 'Les ressources ont été ajoutées avec succès');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}
