<?php

use App\Http\Controllers\EleveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\UEController;
use App\Models\Utilisateur;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\EnseignementController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\AnneeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('professeur')->group(function () {
    Route::get('/dashprof', function () {
        return view('dashprof');
    })->name('dashprof');
});

Route::get('/dashadmin', function () {
    return view('dashboards.dashAdmin');
})->name('dashadmin');

Route::get('/ajoutEleve', function () {
    return view('ajouts.ajoutEleves');
})->name('ajoutEleve');

Route::get('/ajoutAnnees', function () {
    return view('ajouts.ajoutAnnees');
})->name('ajoutAnnees');

Route::get('/ajoutsParcours', function () {
    return view('ajouts.ajoutsParcours');
})->name('ajoutsParcours');

Route::get('/ajoutEval', function () {
    return view('ajouts.ajoutEvals');
})->name('ajoutEval');

Route::get('/ajoutRessource', function () {
    return view('ajouts.ajoutRessources');
})->name('ajoutRessource');

Route::get('/ajoutEnseignements', function () {
    return view('ajouts.ajoutEnseignements');
})->name('ajoutEnseignements');

Route::get('/ajoutProfs', function () {
    return view('ajouts.ajoutProfs');
})->name('ajoutProfs');

Route::get('/ajoutSemestre', function () {
    return view('ajouts.ajoutSemestres');
})->name('ajoutSemestre');

Route::get('/ajoutGroupe', function () {
    return view('ajouts.ajoutGroupes');
})->name('ajoutGroupe');

Route::get('/ajoutUE', function () {
    return view('ajouts.ajoutUEs');
})->name('ajoutUE');

Route::get('/evaluation', function () {
    return view('evaluation');
})->name('evaluation');

Route::get('/visuNote', function () {
    return view('visuNote');
})->name('visuNote');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/modifierMDP',[UtilisateurController::class,'modifierMDP'])->name('modifierMDP');
    Route::post('/modifierNotif',[UtilisateurController::class,'modifierNotif'])->name('modifierNotif');
    Route::get('/profil',[UtilisateurController::class,'show'])->name('profil');
});

require __DIR__.'/auth.php';

Route::middleware('professeur')->group(function () {
    Route::resource('evaluation', EvaluationController::class);
    Route::resource('evaluation', EvaluationController::class)->name("index","evaluations");


    Route::get('/dashprof', function () {
        return view('dashprof');
    })->name('dashprof');

    Route::get('/evaluation/{id}/stats', [EvaluationController::class, 'showStats'])->name('evaluation.stats');

    Route::post('saisir_note',[EvaluationController::class, 'saisirNote'])->name('saisir_note');
    Route::post('saisir_notes',[EvaluationController::class, 'saisirNotes'])->name('saisir_notes');
});
Route::post('importEval', [EvaluationController::class, 'import'])->name("importEval");
Route::post('importEvals', [EvaluationController::class, 'import'])->name("importEvals");
Route::post('importEleves', [EleveController::class, 'addManyStudents'])->name("importEleves");
Route::post('importEleve', [EleveController::class, 'addOneStudent'])->name("importEleve");
Route::post('importRessources', [RessourceController::class, 'import'])->name("importRessources");
Route::post('importSemestres', [SemestreController::class, 'import'])->name("importSemestres");
Route::post('importAnnees', [AnneeController::class, 'import'])->name("importAnnees");
Route::post('importGroupes', [GroupeController::class, 'import'])->name("importGroupes");
Route::post('importUEs', [UEController::class, 'import'])->name("importUEs");
Route::post('importParcours', [ParcoursController::class, 'import'])->name("importParcours");
Route::post('importEnseignements', [EnseignementController::class, 'import'])->name("importEnseignements");
Route::post('importProfs', [ProfController::class, 'import'])->name("importProfs");
Route::get('pdf/{id}', [EleveController::class, 'exportBulletinPDF'])->name('pdf');
Route::middleware('eleve')->group(function () {
    Route::resource('visualisation', EleveController::class);
});

Route::middleware('administrateur')->group(function () {
    Route::get('/dashadmin', function () {
        return view('dashboards.dashAdmin');
    })->name('dashadmin');
    Route::resource('profs', ProfController::class);
    Route::resource('ue', UEController::class);
    Route::resource('utilisateurs',UtilisateurController::class);
    Route::resource('parcours', ParcoursController::class);
    Route::resource('ressources', RessourceController::class);
    Route::resource('enseignements', EnseignementController::class);
    Route::resource('groupes', GroupeController::class);
    Route::resource('annees', AnneeController::class);
    Route::resource('semestres', SemestreController::class);
    Route::resource('ressource', RessourceController::class);
    Route::get('/afficherEleves', [EleveController::class, 'afficherEleves'])->name('afficherEleves');
    Route::get('/afficherEvals', [EvaluationController::class, 'afficherEvals'])->name('afficherEvals');
    Route::get('/afficherEnseignement', [EnseignementController::class, 'index'])->name('afficherEns');
    Route::get('/afficherGroupes', [GroupeController::class, 'index'])->name('afficherGroupes');
    Route::get('/afficherGroupesInfo', [GroupeController::class, 'infoGroupe'])->name('infoGoupes');
    Route::get('/afficherAnnees', [AnneeController::class, 'index'])->name('afficherAnnees');
    Route::get('/afficherSemestres', [SemestreController::class, 'index'])->name('afficherSemestres');
    Route::get('/afficherParcours', [ParcoursController::class, 'index'])->name('afficherParcours');
    Route::get('/afficherRessource', [RessourceController::class, 'index'])->name('afficherRessources');
    Route::post('/ajouterEnseignements',[EnseignementController::class,'ajouterEnseignements'])->name('ajouterEnseignements');
    Route::get('/ajoutUtilisateur', [UtilisateurController::class, 'create'])->name('ajoutUtilisateur');
    Route::delete('supprimerProf',[ProfController::class, 'destroy' ])->name('supprimerProf');
    Route::delete('supprimerEnseignement',[EnseignementController::class, 'destroy' ])->name('supprimerEnseignement');
    Route::delete('supprimerEval',[EvaluationController::class, 'destroy' ])->name('supprimerEval');
    Route::delete('supprimerSemestre',[SemestreController::class, 'destroy' ])->name('supprimerSemestre');
    Route::delete('supprimerAnnee',[AnneeController::class, 'destroy' ])->name('supprimerAnnee');
    Route::delete('supprimerParcours',[ParcoursController::class, 'destroy' ])->name('supprimerParcours');
    Route::delete('supprimerGroupe',[GroupeController::class, 'destroy' ])->name('supprimerGroupe');
    Route::delete('supprimerEleve',[EleveController::class, 'destroy' ])->name('supprimerEleve');
    Route::delete('supprimerRessource',[RessourceController::class, 'destroy' ])->name('supprimerRessource');
    Route::get('/supprimerEleveGroupe',[GroupeController::class, 'delElevesFromGroupes' ])->name('supprimerEleveGroupe');
    Route::get('/supprimerRessourceGroupe',[GroupeController::class, 'delRessourceFromGroupes' ])->name('supprimerRessourceGroupe');
    Route::post('/addEleveGroupe',[GroupeController::class, 'addEleveToGroupe' ])->name('addEleveGroupe');
    Route::post('/addRessourceGroupe',[GroupeController::class, 'addRessourceToGroupe' ])->name('addRessourceGroupe');
});

Route::get('pdf/{id}', [EleveController::class, 'exportBulletinPDF'])->name('pdf');


Route::get('email', [NotifController::class, 'getRouteMail']);

Route::post('/envoyerNotif', [NotifController::class, 'envoyerEmail'])->name('envoyerNotif');

