<?php

use Illuminate\Support\Facades\Route;
use App\Models\Theme; 
use App\Http\Controllers\MainSite\AuthController;
use App\Http\Controllers\MainSite\MenuController as PublicMenuController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\AccountController;

// Accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Menus
Route::get('/menus', [PublicMenuController::class, 'index'])->name('menus');
Route::get('/menus/{id}', [PublicMenuController::class, 'show'])->name('menus.show')->where('id', '[0-9]+');

// Connexion et Inscription
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Mot de passe oublié
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Pages d'information
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

// Espaces connectés
Route::middleware(['auth'])->group(function () {

    // Espace Employé
    Route::get('/employe/dashboard', function () {
        return view('employe.dashboard');
    })->middleware(\App\Http\Middleware\CheckRole::class . ':2')->name('employe.dashboard');

    // Espace Client
    Route::get('/customer/dashboard', [CustomerDashboard::class, 'index'])
        ->middleware(\App\Http\Middleware\CheckRole::class . ':3')
        ->name('customer.dashboard');

    // Profil
    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Raccourci création commande
    Route::get('/order/create', [OrderController::class, 'create']);

    // Actions Client
    Route::prefix('client')->group(function () {

        // Mon compte
        Route::get('/compte', [AccountController::class, 'index'])->name('customer.account');
        Route::put('/compte', [AccountController::class, 'update'])->name('customer.account.update');

        // Mes commandes
        Route::get('/commandes', [OrderController::class, 'index'])->name('customer.orders');
        Route::get('/commande/creer', [OrderController::class, 'create'])->name('order.create');
        Route::post('/commande', [OrderController::class, 'store'])->name('order.store');
        Route::post('/commandes/estimer-frais', [OrderController::class, 'estimateFee'])->name('customer.orders.estimate');

        // Détails commande
        Route::get('/commandes/{id}', [OrderController::class, 'show'])->name('customer.order-details');

        // Modifier / Annuler commande
        Route::get('/commandes/{id}/modifier', [OrderController::class, 'edit'])->name('customer.orders.edit');
        Route::put('/commandes/{id}', [OrderController::class, 'update'])->name('customer.orders.update');
        Route::patch('/commandes/{id}/annuler', [OrderController::class, 'cancel'])->name('customer.orders.cancel');

        // Avis
        Route::post('/commandes/{id}/avis', [ReviewController::class, 'store'])->name('customer.reviews.store');

        // Paiement Stripe
        Route::get('/commande/{id}/payment/success', [PaymentController::class, 'success'])->name('customer.payment.success');
        Route::get('/commande/{id}/payment/cancel', [PaymentController::class, 'cancel'])->name('customer.payment.cancel');
    });
});

// Test BDD
Route::get('/test-bdd', function () {
    try {
        $themes = Theme::all();
        return response()->json($themes);
    } catch (\Exception $e) {
        return "Erreur lors de la récupération : " . $e->getMessage();
    }
});