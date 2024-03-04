<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $table = 'ressources';
    protected $fillable = ["libelle","code"];
    protected $primaryKey = "code";

    public $timestamps = false;

    public $incrementing = false;

    public function enseignements(){
        return $this->hasMany(Enseignement::class, 'code_ressource', 'code');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'code_ressource');
    }

    public function ue() {
        return $this->belongsToMany(UE::class, "coefficient_ue", "code_ressource", "code_ue")->withPivot("coefficient");
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class,"ressource_groupe","code_ressource","id_groupe");
    }

    public function groupe() {
        return $this->belongsToMany(Groupe::class,"enseignements", "code_ressource", "id_groupe")->withPivot("code_prof");
    }

    public function professeur() {
        return $this->belongsToMany(Professeur::class,"enseignements", "code_ressource", "code_prof");
    }
}