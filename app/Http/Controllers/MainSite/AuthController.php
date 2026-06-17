<?php

namespace App\Http\Controllers\MainSite;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('main-site.register');
    }

    /**
     * Gère la logique d'inscription (Vite & Gourmand Style)
     */
    public function register(RegisterRequest $request)
    {
        // 1. Les données arrivant ici sont DÉJÀ validées et nettoyées par RegisterRequest
        
        // 2. Création de l'utilisateur en base de données
        $user = User::create([
            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'adresse'   => $request->adresse,
            'password'  => Hash::make($request->password), // Hachage sécurisé du mot de passe
            'statut'    => 1, // Activé par défaut pour tes tests (on gérera le mail d'activation en Phase 4)
            'role_id'   => 3, // Par défaut : 3 = Client/Utilisateur (À adapter selon tes IDs de rôles en base)
        ]);

        // 3. Connecter automatiquement l'utilisateur après son inscription
        Auth::login($user);

        // 4. Redirection vers la page d'accueil avec un message flash de succès
        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès ! Bienvenue chez Vite & Gourmand.');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('main-site.login');
    }

    /**
     * Gère la tentative de connexion
     */
    public function login(Request $request)
    {
        // Validation rapide et locale pour la connexion
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'adresse e-mail est requise.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        // Tentative d'authentification
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // Sécurité : Protection contre la fixation de session

            $user = Auth::user();

            // Vérification du statut du compte (Ex: banni ou inactif)
            if ($user->statut == 0) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte est actuellement désactivé. Veuillez contacter le support.']);
            }

            // Redirection dynamique selon le rôle
            return redirect()->route($this->getDashboardRoute($user))
                             ->with('success', 'Bon retour parmi nous, ' . $user->prenom . ' !');
        }

        // Échec de la connexion
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Gère la déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken(); // Sécurité : Régénération du token CSRF

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Détermine la route de redirection selon le rôle de l'utilisateur (Architecture Pro)
     */
    private function getDashboardRoute(User $user): string
    {
        // Si l'utilisateur est Admin (Ex: role_id 1) ou Employé (Ex: role_id 2) -> Direction le Dashboard
        // Si c'est un Client (Ex: role_id 3) -> Direction l'accueil du site
        return in_array($user->role_id, [1, 2]) ? 'admin.dashboard' : 'home';
    }
}