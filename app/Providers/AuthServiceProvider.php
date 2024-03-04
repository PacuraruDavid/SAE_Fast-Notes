<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Utilisateur;
use App\Models\Admin;
use App\Models\Eleve;
use App\Models\Professeur;





class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();

        Gate::define('isAdmin', function(Utilisateur $user){
            return Admin::find($user->code) != null;
        });

        Gate::define('isProf', function(Utilisateur $user){
            return Professeur::find($user->code) != null;
        });

        Gate::define('isEleve', function(Utilisateur $user){
            return Eleve::find($user->code) != null;
        });

        Gate::define('matchId', function (Utilisateur $user, $id) {
            return $user->code === $id;
        });
    }
}
