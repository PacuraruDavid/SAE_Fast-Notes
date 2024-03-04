<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = ["libelle"];

    protected $primaryKey = "code";
    protected $table = "competences";
    public $incrementing = false;
    public $timestamps = false;


    public function ue(){
        return $this->hasMany(UE::class, "code", "code");
    }

    use HasFactory;
}
