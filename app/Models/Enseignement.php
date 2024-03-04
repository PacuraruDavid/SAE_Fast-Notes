<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;
    protected $primaryKey = array('code_prof', 'id_groupe', 'code_ressource');

    protected $fillable = ['code_prof', 'id_groupe', 'code_ressource'];

    protected $table = "enseignements";

    public function professeur () {
        return $this->hasOne(Professeur::class,"code","code_prof");
    }

    public function ressource () {
        return $this->hasOne(Ressource::class,"code","code_ressource");
    }

    public function groupe () {
        return $this->hasOne(Groupe::class,"id","id_groupe");
    }
}
