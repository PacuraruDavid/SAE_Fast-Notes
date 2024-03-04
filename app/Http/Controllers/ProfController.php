<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Semestre;
use App\Models\Utilisateur;
use App\Models\Ressource;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProfsImport;

use DB;
use Illuminate\Support\Facades\Hash;


class ProfController extends Controller
{
    public function index(){
        $tabProf = Professeur::all();
        $listeUtilisateurs = [];
        foreach ($tabProf as $prof) {
            array_push($listeUtilisateurs,$prof->utilisateur) ;
        }
        return view('affichage_elements.listeProfs', compact('tabProf','listeUtilisateurs'));
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'code' => 'required|string|max:255|unique:users',
            'confirm_password'=>'required|same:password',
            'email'=>'required|string|max:255'],$customErrorMessages
        );


        $utilisateur = Utilisateur::create(['nom'=>$request->input('nom'),
        'prenom'=>$request->input('prenom'),
        'code'=>$request->input('code'),
        'password'=>Hash::make($request->input('password')),
        'email'=>$request->input('email')]);

        $prof = Professeur::create(['code'=>$request->input('code'), 'isProf'=>true, 'utilisateur'=>$utilisateur]);

        return redirect()->route('profs.index')->withErrors($validator);


    }
    

    public function show(string $idProf) {

        $prof = Professeur::with('enseignements')->findOrFail($idProf);
        $utilisateur = $prof->utilisateur;
        $enseignements = $prof->enseignements;
        $listeRessources = Ressource::all();
        $listeGroupes = Groupe::all();
        $resListe = [];
        foreach ($enseignements as $enseignement) {
            $groupe = Groupe::findOrFail($enseignement->id_groupe);
            $parcours = Parcours::find($groupe->parcours);
            $ressource = Ressource::findOrFail($enseignement->code_ressource);
            if ($parcours == null) {
                $libelleSemestre = " - ";
                $anneeSemestre = " - ";
            }
            else {
                $libelleSemestre = $parcours->semestre["libelle"];
                $anneeSemestre = $parcours->semestre["id_annee"];
            }
            array_push($resListe,["nomRessource" => $ressource["libelle"],"groupe" => $groupe->libelle,"semestre"=>$libelleSemestre,"periode"=>$anneeSemestre]);
        }
        return view ('affichage_elements.infoProf',compact('utilisateur','resListe','listeRessources','listeGroupes'));

    }

    public function destroy(Request $request) {
        $profId = $request->input('prof');

        $prof = Professeur::findOrFail($profId);
        $user = Utilisateur::findOrFail($profId);

        $req = DB::table('enseignements')
        ->where('code_prof',$prof->code)
        ->delete();

        $prof->delete();
        $user->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function import(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new ProfsImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successImportingProfs', 'Les professeurs ont été ajoutés avec succés');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}
