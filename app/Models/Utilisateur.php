<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $primaryKey = 'code';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'code',
        'password',
        'email',
        'nom',
        'prenom'
    ];

    protected $table = "users";
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function eleves(){
        return $this->hasMany(Eleve::class, 'code','code');
    }    
    public function admin(){
        return $this->hasMany(Admin::class, 'code','code');
    }    
    public function professeur(){
        return $this->hasMany(Professeur::class, 'code','code');
    }
}
