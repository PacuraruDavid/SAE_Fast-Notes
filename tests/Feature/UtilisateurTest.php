<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Utilisateur;
use App\Models\Evaluation;
use App\Models\Eleve;
use App\Models\UE;
use App\Models\Professeur;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\EleveController;
use App\Models\Competence;
use App\Models\Groupe;
use App\Models\Ressource;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UtilisateurTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithoutMiddleware;
    public function test_guest_cant_see_notes(): void
    {
        $user = Utilisateur::factory()->create();

        $response = $this->get('visualisation/'.$user->code);

        $response->assertStatus(403);

    }

    public function test_eleve_can_see_his_notes(): void
    {
        $user = Eleve::factory()->create();

        $response = $this->actingAs($user)->get('visualisation/'.$user->code);

        $response->assertStatus(200);

    }

    public function test_eleve_can_only_see_his_notes(): void
    {
        $user = Eleve::factory()->create();
        $user2 = Eleve::factory()->create();

        $response = $this->actingAs($user)->get('visualisation/'.$user2->code);

        $response->assertStatus(403);

    }


    
    public function test_moyenne(): void
    {
        

        $eleve = Eleve::factory()->create();
        $this->actingAs($eleve);
        $ressource = Ressource::factory()->create();
        $ue = UE::factory()->create();
        $groupe = Groupe::factory()->create(['libelle'=>'groupe1']);
        
        $ressource->ue()->syncWithoutDetaching([
            $ue->code => ['coefficient' => 1]
        ]);

        $groupe->ressources()->attach($ressource);

        $eleve->groupe = $groupe;
        

        $eval = Evaluation::factory()->create(['coefficient' => 1, 'code_ressource' => $ressource]);
        $eval2 = Evaluation::factory()->create(['coefficient' => 1,'code_ressource' => $ressource ]);
        
        
        $eval->eleves()->syncWithoutDetaching([
            $eleve->code => ['note' => 10]
        ]);

        $eval2->eleves()->syncWithoutDetaching([
            $eleve->code => ['note' => 5]
        ]);

         
        $controller = app(EleveController::class);
        $liste = $controller->listeCompetences($eleve);
        dd($liste);
        $tamereDB = Groupe::findOrFail($groupe->id);
        $moyenne = $controller->moyenneSemestre($eleve->code);
        //dd(Groupe::Find($groupe->id));
        assertEquals(7.5,$moyenne);
        
        

    }
}
