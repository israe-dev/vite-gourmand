<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PlatController;
use App\Http\Controllers\Admin\MenuTagController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\AdminMenuController;

// Ce fichier est inclus automatiquement au sein du groupe middleware ['auth', CheckRole::class . ':1']
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':1'])->group(function () {

    // Dashboard Général Admin
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // 1. Entité : Plats (PlatController)
    Route::get('/admin/plats', [PlatController::class, 'index'])->name('admin.plats.index');
    Route::post('/admin/plats', [PlatController::class, 'store'])->name('admin.plats.store');
    Route::delete('/admin/plats/{id}', [PlatController::class, 'destroy'])->name('admin.plats.destroy');

    // 2. Entité : Menu Tags (MenuTagController)
    Route::get('/admin/allergenes', [MenuTagController::class, 'index'])->name('admin.allergenes.index');
    Route::post('/admin/allergenes', [MenuTagController::class, 'storeAllergene'])->name('admin.allergenes.store');
    Route::post('/admin/regimes', [MenuTagController::class, 'storeRegime'])->name('admin.regimes.store');

    // 3. Entité : Thèmes (ThemeController isolé)
    Route::get('/admin/themes', [ThemeController::class, 'index'])->name('admin.themes.index');
    Route::post('/admin/themes', [ThemeController::class, 'store'])->name('admin.themes.store');
    Route::delete('/admin/themes/{id}', [ThemeController::class, 'destroy'])->name('admin.themes.destroy');

    // 4. Entité : Menus (Lié à ton nouveau AdminMenuController propre)
    Route::get('/admin/menus', [AdminMenuController::class, 'index'])->name('admin.menus.index');
    Route::post('/admin/menus', [AdminMenuController::class, 'store'])->name('admin.menus.store');
    Route::get('/admin/menus/{id}', [AdminMenuController::class, 'show'])->name('admin.menus.show');
    Route::put('/admin/menus/{id}', [AdminMenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/admin/menus/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menus.destroy');

    // Autre historique restant sur l'ancien Dashboard de transition
    Route::get('/admin/commandes', [AdminDashboard::class, 'commandes'])->name('admin.commandes.index');
    Route::get('/admin/avis', [AdminDashboard::class, 'avis'])->name('admin.avis.index');
});