<?php

namespace App\Http\Controllers\MainSite;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Gérer la tentative de connexion (Multi-rôles)
     */
    public function login(Request $request)
    {
        // Validation basique des identifiants
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Recherche de l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Vérification du mot de passe
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Vérification si le compte est actif (statut = 1)
            if ($user->statut == 1) {
                Auth::login($user);
                
                // Redirection dynamique selon le rôle ECF
                return redirect()->route($this->getDashboardRoute($user));
            }

            // Gestion des comptes bloqués ou bannis
            if ($user->notice === "banned" || $user->statut == 0) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte est inactif ou suspendu. Veuillez contacter le support.'
                ]);
            }
        }

        // Erreur générique si la tentative échoue
        return back()->withErrors([
            'email' => 'Identifiants de connexion incorrects.',
        ])->withInput($request->only('email'));
    }

    /**
     * Étape A : Afficher le formulaire "Mot de passe oublié"
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Étape B : Traiter la demande et envoyer le lien par mail
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validation de l'adresse email
        $request->validate(['email' => 'required|email']);

        // Le Password::broker de Laravel va générer un token unique, le stocker en BDD, 
        // et tenter d'envoyer le mail à l'utilisateur
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        // Si tout s'est bien passé, Laravel retourne une constante de succès
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Le lien de réinitialisation a été envoyé sur votre adresse e-mail.');
        }

        // Si l'adresse e-mail n'existe pas ou qu'on a tenté trop de requêtes
        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Étape C : Afficher le formulaire de saisie du nouveau mot de passe
     * (Déclenché quand l'utilisateur clique sur le lien reçu par mail)
     */
    public function showResetPasswordForm($token, Request $request)
    {
        // On passe le token et l'email à la vue pour sécuriser la modification
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Étape D : Enregistrer le nouveau mot de passe en base de données
     */
    public function resetPassword(Request $request)
    {
        // Validation des critères de sécurité (Exigence ECF minimum 10 caractères)
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed', // 'confirmed' vérifie que 'password_confirmation' est identique
        ]);

        // Procédure de mise à jour sécurisée via Laravel
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // On met à jour le mot de passe (le hachage s'effectue automatiquement via le modèle User)
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Déclenche l'événement natif Laravel
                event(new PasswordReset($user));
            }
        );

        // Si la réinitialisation est un succès
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Votre mot de passe a bien été réinitialisé. Vous pouvez maintenant vous connecter.');
        }

        // En cas d'erreur (ex: lien expiré ou token invalide)
        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Traiter l'inscription d'un nouvel utilisateur (Rôle Client/Utilisateur)
     */
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Données structurelles par défaut adaptées à ta base SQL
        $validatedData['role_id'] = 3; // 3 = Client / Utilisateur
        $validatedData['statut'] = 1;  // Actif immédiatement

        // Création (le mot de passe se hache tout seul via le modèle User)
        $user = User::create($validatedData);

        // Connexion automatique après inscription
        $sn = Auth::login($user);

        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès ! Bienvenue.');
    }

    /**
     * Déterminer la route de redirection selon le rôle exact (Exigence ECF)
     */
    private function getDashboardRoute(User $user): string
    {
        switch ($user->role_id) {
            case 1:
                return 'admin.dashboard';   // Espace Administrateur
            case 2:
                return 'employe.dashboard'; // Espace Employé (Cuisinier / Livreur)
            case 3:
            default:
                return 'home';              // Espace Client / Page d'accueil dynamique
        }
    }

    /**
     * Gérer la déconnexion
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}