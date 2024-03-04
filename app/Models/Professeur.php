<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Utilisateur
{
    use HasFactory;
    protected $table = "professeurs";
    protected $fillable = 
        [
            'code','isProf'
        ];

    public function ressource () {
        return $this->belongsToMany(Ressource::class,"enseignements", "code_prof", "code_ressource");
    }

    public function groupes () {
        return $this->belongsToMany(Groupe::class,"enseignements", "code_prof", "id_groupe");
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class,"code","code");
    }

    public function enseignements()
    {
        return $this->hasMany(Enseignement::class, 'code_prof', 'code');
    }
}
