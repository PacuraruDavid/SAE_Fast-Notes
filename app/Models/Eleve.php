<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Utilisateur
{
    use HasFactory;

    protected $table = "eleves";

    protected $fillable = ['identification', 'id_groupe','code'];


    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'code');
    }

    public function evaluations() {
        return $this->belongsToMany (Evaluation::class, 'note_evaluation', 'code_eleve', 'id_evaluation')
        ->withPivot("note");
    }

    public function groupe() {
        return $this->belongsTo(Groupe::class, "id_groupe", "id");
    }
}
