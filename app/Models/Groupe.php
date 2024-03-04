<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ["id", "libelle", "parcours"];

    protected $id = "id";

    protected $table = "groupes";

    public function eleves () {
        return $this->hasMany(Eleve::class,"id_groupe","id");
    }

    public function ressources() {
        return $this->belongsToMany(Ressource::class,"ressource_groupe","id_groupe","code_ressource");
    }

    public function ressource(){
        return $this->belongsToMany(ressource::class,"enseignements", "id_groupe", "code_ressource");
    }

    public function professeurs(){
        return $this->belongsToMany(ressource::class,"enseignements", "id_groupe", "code_prof");
    }

    public function parcour(){
        return $this->belongsTo(Parcours::class, "parcours","id_parcour");
    }

    public function enseignement(){
        return $this->hasMany(Enseignement::class, "id_groupe", "id");
    }
}
