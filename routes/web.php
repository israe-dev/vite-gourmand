<?php

use Illuminate\Support\Facades\Route;
use App\Models\Theme; //  L'import doit être ICI, tout en haut !
use App\Http\Controllers\MainSite\AuthController;

Route::get('/', function () {
    return view('welcome');
});

//aller vers menus
Route::get('/menus', function () {
    return view('main-site.menus');
});

// Page de détail d'UN menu (le bouton "Je découvre" de l'accueil pointe ici)
Route::get('/menus/1', function () {
    return view('main-site.menu-detail'); // Vérifie bien que le fichier s'appelle menu-detail.blade.php dans le dossier main-site
});

// Page du tunnel de commande
Route::get('/order/create', function () {
    return view('main-site.order');
});

// Pages d'Authentification (Dossier resources/views/auth/)
Route::get('/register', function () {
    return view('auth.register'); // Pointera vers auth/register.blade.php
});

Route::get('/login', function () {
    return view('auth.login'); // Pointera vers auth/login.blade.php
});


// Routes pour l'Inscription (Register)
Route::get('/inscription', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);

// Routes pour la Connexion (Login)
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);

// Route pour la Déconnexion (Logout)
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Page Mentions Légales
Route::get('/mentions-legales', function () {
    return view('main-site.mentions-legales');
});

// Page Conditions Générales de Vente (CGV)
Route::get('/cgv', function () {
    return view('main-site.cgv');
});

// Page Politique de Confidentialité
Route::get('/politique-confidentialite', function () {
    return view('main-site.politique-confidentialite');
});


// Page contact
Route::get('/contact', function () {
    return view('main-site.contact');
});

// ma route de test bien propre
Route::get('/test-bdd', function () {
    try {
        $themes = Theme::all();
        return response()->json($themes); // Permet d'afficher les thèmes proprement à l'écran
    } catch (\Exception $e) {
        return "Erreur lors de la récupération : " . $e->getMessage();
    }
});