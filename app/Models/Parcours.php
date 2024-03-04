<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = "id_parcour";

    protected $fillable = ["id_parcour", "id_semestre"];

    protected $id = "id_parcour";

    protected $table = "parcours";


    public function groupes (){
        return $this->hasMany(Groupe::class, "parcours", "id_parcour");
    }

    public function semestre(){
        return $this->belongsTo(Semestre::class, "id_semestre", "id_semestre");
    }

}
