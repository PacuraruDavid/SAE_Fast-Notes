<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', "Vous devez être connecté pour accéder à cette ressource.")->setStatusCode(403);
    }

    if (Gate::denies('isAdmin')) {
        abort(403, "Vous n'avez pas l'autorisation d'accéder à cette ressource.");
    }

    return $next($request);
}

}
