<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Utilisation de la Façade officielle de Laravel

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
        // 1. Vérifier si l'utilisateur est bien connecté via la Façade Auth
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // 2. Vérifier si le role_id correspond aux rôles autorisés
        if (in_array($user->role_id, $roles)) {
            return $next($request);
        }

        // 3. Si non autorisé, redirection vers l'accueil
        return redirect('/')->with('error', 'Accès non autorisé.');
    }
}