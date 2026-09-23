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
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Affiche le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Gère la tentative de connexion et redirige selon le rôle
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
            
            // Vérification si le compte est actif
            if ($user->statut == 1) {
                Auth::login($user);
                
                // Redirection dynamique selon le rôle
                return redirect()->route($this->getDashboardRoute($user));
            }

            // Gestion des comptes bloqués ou suspendus
            if ($user->notice === "banned" || $user->statut == 0) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte est inactif ou suspendu. Veuillez contacter le support.'
                ]);
            }
        }

        // Erreur si les identifiants ne correspondent pas
        return back()->withErrors([
            'email' => 'Identifiants de connexion incorrects.',
        ])->withInput($request->only('email'));
    }

    // Affiche le formulaire de demande de réinitialisation de mot de passe
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Envoie le lien de réinitialisation par e-mail
    public function sendResetLinkEmail(Request $request)
    {
        // Validation de l'adresse email
        $request->validate(['email' => 'required|email']);

        // Génère un token unique et envoie l'e-mail via le système Laravel
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        // Si l'e-mail est bien parti
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Le lien de réinitialisation a été envoyé sur votre adresse e-mail.');
        }

        // En cas d'erreur (adresse inconnue ou trop de demandes)
        return back()->withErrors(['email' => __($status)]);
    }

    // Affiche le formulaire pour saisir le nouveau mot de passe
    public function showResetPasswordForm($token, Request $request)
    {
        // On passe le token et l'email à la vue
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Enregistre le nouveau mot de passe en base de données
    public function resetPassword(Request $request)
    {
        // Validation des critères de sécurité
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
        ]);

        // Réinitialisation effective via Laravel
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Met à jour le mot de passe (le hachage se fait via le modèle)
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Déclenche l'événement de réinitialisation
                event(new PasswordReset($user));
            }
        );

        // Si tout s'est bien passé
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Votre mot de passe a bien été réinitialisé. Vous pouvez maintenant vous connecter.');
        }

        // En cas d'erreur (token expiré, etc.)
        return back()->withErrors(['email' => __($status)]);
    }

    // Traite l'inscription d'un nouvel utilisateur
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Attributs par défaut pour un nouveau client
        $validatedData['role_id'] = 3; // 3 = Client
        $validatedData['statut'] = 1;  // Actif par défaut

        // Création de l'utilisateur
        $user = User::create($validatedData);

        // Connexion automatique après l'inscription
        $sn = Auth::login($user);

        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès ! Bienvenue.');
    }

    // Détermine la route du tableau de bord selon le rôle exact
    private function getDashboardRoute(User $user): string
    {
        switch ($user->role_id) {
            case 1:
                return 'admin.dashboard';   // Administrateur
            case 2:
                return 'employe.dashboard'; // Employé (Cuisinier / Livreur)
            case 3:
            default:
                return 'home';              // Client
        }
    }

    // Déconnecte l'utilisateur
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}