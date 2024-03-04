<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique_Groupes extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ["code_etudiant", "id_groupe"];

    protected $id = array("code_etudiant", "id_groupe");

    protected $table = "ancien_groupes";

    public function groupe(){
        return $this->hasMany(Groupe::class,"id", "id_groupe");
    }

    public function eleve(){
        return $this->hasMany(Eleve::class,"code", "code_etudiant");
    }
}
