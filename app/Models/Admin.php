<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Utilisateur
{
    use HasFactory;

    protected $table = 'admins';
    protected $fillable =
        [
            'code','isAdmin'
        ]
        ;
    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class,"code","code");
    }
}
