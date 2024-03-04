<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {       
        Schema::create('annees', function (Blueprint $table) {
            $table->string('id_annee');
            $table->primary('id_annee');
            $table->integer('annee_debut');
            $table->integer('annee_fin');
        });
        
        Schema::create('competences', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('libelle');
        });
        
        Schema::create('ressources', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('libelle');
        });

        Schema::create('semestres', function (Blueprint $table) {
            $table->string('id_semestre');
            $table->primary('id_semestre');
            $table->string('libelle');
            $table->string('id_annee');
            $table->foreign('id_annee')->references('id_annee')->on('annees');
        });

        Schema::create('parcours', function (Blueprint $table) {
            $table->string('id_parcour');
            $table->primary('id_parcour');
            $table->string('id_semestre');
            $table->foreign('id_semestre')->references('id_semestre')->on('semestres');
        });

        Schema::create('groupes', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('libelle');
            $table->string('parcours');
            $table->foreign('parcours')->references('id_parcour')->on('parcours');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('password');
            $table->string('email');
            $table->string('nom');
            $table->string('prenom');
        });

        Schema::create('professeurs', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->boolean('isProf');
            $table->foreign('code')->references('code')->on('users');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->boolean('isAdmin');
            $table->foreign('code')->references('code')->on('users');
        });

        Schema::create('eleves', function (Blueprint $table) {
            $table->string('code');
            $table->primary('code');
            $table->string('identification');
            $table->string('id_groupe');
            $table->foreign('id_groupe')->references('id')->on('groupes');
            $table->foreign('code')->references('code')->on('users');
        });
        
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->float('coefficient');
            $table->string('type');
            $table->timestamp('date_epreuve')->nullable()->default(null);
            $table->timestamp('date_rattrapage')->nullable()->default(null);
            $table->string('code_ressource');
            $table->foreign('code_ressource')->references('code')->on('ressources');
        });

        Schema::create('ue', function (Blueprint $table) {
            $table->string("code");
            $table->primary("code");
            $table->string('libelle');
            $table->string('code_competence');
            $table->string('id_semestre');
            $table->foreign('code_competence')->references('code')->on('competences');
            $table->foreign('id_semestre')->references('id_semestre')->on('semestres');
        });
        
        Schema::create('note_evaluation', function (Blueprint $table) {
            $table->string('note');
            $table->unsignedBigInteger('id_evaluation');
            $table->string('code_eleve');
            $table->foreign('code_eleve')->references('code')->on('eleves');
            $table->foreign('id_evaluation')->references('id')->on('evaluations');
            $table->primary(['id_evaluation', 'code_eleve']);
        });
        
        Schema::create('coefficient_ue', function (Blueprint $table) {
            $table->string('code_ressource');
            $table->string('code_ue');
            $table->foreign('code_ressource')->references('code')->on('ressources');
            $table->foreign('code_ue')->references('code')->on('ue');
            $table->float('coefficient');
            $table->primary(['code_ue', 'code_ressource']);
        });
        
        Schema::create('ressource_groupe', function (Blueprint $table) {
            $table->string('id_groupe');
            $table->string('code_ressource');
            $table->foreign('code_ressource')->references('code')->on('ressources');
            $table->foreign('id_groupe')->references('id')->on('groupes');
            $table->primary(['id_groupe', 'code_ressource']);
        });
        
        Schema::create('enseignements', function (Blueprint $table) {
            $table->string('code_prof');
            $table->string('id_groupe');
            $table->string('code_ressource');
            $table->foreign('code_prof')->references('code')->on('professeurs');
            $table->foreign('id_groupe')->references('id')->on('groupes');
            $table->foreign('code_ressource')->references('code')->on('ressources');
            $table->primary(['id_groupe', 'code_ressource', 'code_prof']);
        });

        Schema::create('ancien_groupes', function (Blueprint $table) {
            $table->string("code_etudiant");
            $table->string("id_groupe");
            $table->foreign('code_etudiant')->references('code')->on('eleves');
            $table->foreign('id_groupe')->references('id')->on('groupes');
            $table->primary(['id_groupe','code_etudiant']);
        });

        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
        Schema::dropIfExists('groupes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('professeurs');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('eleves');
        Schema::dropIfExists('ressource');
        Schema::dropIfExists('competences');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('ue');
        Schema::dropIfExists('note_evaluation');
        Schema::dropIfExists('coefficient_ue');
        Schema::dropIfExists('ressource_groupe');
        Schema::dropIfExists('enseignements');
        Schema::dropIfExists('annee');
        Schema::dropIfExists('parcours');
        Schema::dropIfExists('ancien_groupes');
    }
};
