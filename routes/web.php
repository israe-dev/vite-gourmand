<?php

use Illuminate\Support\Facades\Route;
use App\Models\Theme; 
use App\Http\Controllers\MainSite\AuthController;
use App\Http\Controllers\MainSite\MenuController as PublicMenuController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ReviewController;

// --- PAGE D'ACCUEIL & MENUS ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes dynamiques pour l'affichage et le filtrage des menus (Site public)
Route::get('/menus', [PublicMenuController::class, 'index'])->name('menus');
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

    // Gestion du profil utilisateur
    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Alias direct pour l'URL /order/create appelée depuis les fiches menus
    Route::get('/order/create', [OrderController::class, 'create']);

    // Routes client protégées par authentification
    Route::prefix('client')->group(function () {

        // Historique et création de commande
        Route::get('/commandes', [OrderController::class, 'index'])->name('customer.orders');
        Route::get('/commande/creer', [OrderController::class, 'create'])->name('order.create');
        Route::post('/commande', [OrderController::class, 'store'])->name('order.store');
        Route::post('/commandes/estimer-frais', [OrderController::class, 'estimateFee'])->name('customer.orders.estimate');

        // Détail d'une commande
        Route::get('/commandes/{id}', [OrderController::class, 'show'])->name('customer.order-details');

        // Modification et annulation (autorisées seulement si statut = "en attente")
        Route::get('/commandes/{id}/modifier', [OrderController::class, 'edit'])->name('customer.orders.edit');
        Route::put('/commandes/{id}', [OrderController::class, 'update'])->name('customer.orders.update');
        Route::patch('/commandes/{id}/annuler', [OrderController::class, 'cancel'])->name('customer.orders.cancel');

        // Dépôt d'avis (autorisé seulement si statut = "terminée")
        Route::post('/commandes/{id}/avis', [ReviewController::class, 'store'])->name('customer.reviews.store');
    });
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