<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;
    protected $table = "annees";
    protected $fillable = [
        "id_annee","annee_debut", "annee_fin"
    ];
    public $timestamps = false;
    public $primaryKey = "id_annee";
    public $incrementing = false;

    public function semestres(){
        return $this->hasMany(Semestre::class, 'id_annee', 'id_annee');
    }
}
