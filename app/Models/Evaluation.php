<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ["libelle","coefficient","type","date_epreuve","date_fin_epreuve","date_rattrapage","code_ressource"];

    public $timestamps = false;
    protected $table = "evaluations";

    public function eleves () {
        return $this->belongsToMany(Eleve::class, 'note_evaluation', 'id_evaluation', 'code_eleve')
        ->withPivot('note');
    }

    public function ressource () {
        return $this->belongsTo(Ressource::class, "code_ressource");
    }
}
