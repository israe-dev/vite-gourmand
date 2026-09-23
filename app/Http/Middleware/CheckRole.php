<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|int  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // On vérifie d'abord si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // On regarde si son rôle fait partie de ceux autorisés
        if (in_array($user->role_id, $roles)) {
            return $next($request);
        }

        // Si l'accès est refusé, on le renvoie à l'accueil
        return redirect('/')->with('error', 'Accès non autorisé.');
    }
}