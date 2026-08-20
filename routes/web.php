<?php

use Illuminate\Support\Facades\Route;
use App\Models\Theme; 
use App\Http\Controllers\MainSite\AuthController;
use App\Http\Controllers\MainSite\MenuController as PublicMenuController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\OrderController;

// --- PAGE D'ACCUEIL & MENUS ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes dynamiques pour l'affichage et le filtrage des menus (Site public)
Route::get('/menus', [PublicMenuController::class, 'index'])->name('menus');

// SEULE MODIFICATION ICI : On force l'ID à n'être que des chiffres pour qu'il arrête d'intercepter tout le reste
Route::get('/menus/{id}', [PublicMenuController::class, 'show'])->name('menus.show')->where('id', '[0-9]+');


// --- SYSTEME D'AUTHENTIFICATION (CONNEXION / INSCRIPTION / DECONNEXION) ---
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);

Route::get('/inscription', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');


// --- RÉINITIALISATION DE MOT DE PASSE (PASSWORD RESET) ---
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// --- PAGES SECONDAIRES & CONTACT ---
Route::get('/contact', function () {
    return view('main-site.contact');
})->name('contact');

Route::get('/mentions-legales', function () {
    return view('main-site.mentions-legales');
})->name('mentions.legales');

Route::get('/cgv', function () {
    return view('main-site.cgv');
})->name('cgv');

Route::get('/politique-confidentialite', function () {
    return view('main-site.politique-confidentialite');
})->name('politique.confidentialite');


// --- ESPACES UTILISATEURS SÉCURISÉS (EMPLOYÉS & CLIENTS) ---
Route::middleware(['auth'])->group(function () {

    // Seul le rôle 2 (Employé) peut entrer ici
    Route::get('/employe/dashboard', function () {
        return view('employe.dashboard');
    })->middleware(\App\Http\Middleware\CheckRole::class . ':2')->name('employe.dashboard');

    // Seul le rôle 3 (Client) peut entrer ici
    Route::get('/customer/dashboard', [CustomerDashboard::class, 'index'])
        ->middleware(\App\Http\Middleware\CheckRole::class . ':3')
        ->name('customer.dashboard');

    // Tout utilisateur connecté peut passer commande
    Route::get('/order/create', function () {
        return view('main-site.order');
    })->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
});


// --- ROUTE DE TEST BASE DE DONNÉES ---
Route::get('/test-bdd', function () {
    try {
        $themes = Theme::all();
        return response()->json($themes); 
    } catch (\Exception $e) {
        return "Erreur lors de la récupération : " . $e->getMessage();
    }
});