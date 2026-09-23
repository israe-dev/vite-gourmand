<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PlatController;
use App\Http\Controllers\Admin\MenuTagController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\AdminMenuController;

// Accès réservé aux administrateurs
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':1'])->group(function () {

    // Tableau de bord
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // Plats
    Route::get('/admin/plats', [PlatController::class, 'index'])->name('admin.plats.index');
    Route::post('/admin/plats', [PlatController::class, 'store'])->name('admin.plats.store');
    Route::delete('/admin/plats/{id}', [PlatController::class, 'destroy'])->name('admin.plats.destroy');

    // Allergènes et Régimes
    Route::get('/admin/allergenes', [MenuTagController::class, 'index'])->name('admin.allergenes.index');
    Route::post('/admin/allergenes', [MenuTagController::class, 'storeAllergene'])->name('admin.allergenes.store');
    Route::post('/admin/regimes', [MenuTagController::class, 'storeRegime'])->name('admin.regimes.store');

    // Thèmes
    Route::get('/admin/themes', [ThemeController::class, 'index'])->name('admin.themes.index');
    Route::post('/admin/themes', [ThemeController::class, 'store'])->name('admin.themes.store');
    Route::delete('/admin/themes/{id}', [ThemeController::class, 'destroy'])->name('admin.themes.destroy');

    // Menus
    Route::get('/admin/menus', [AdminMenuController::class, 'index'])->name('admin.menus.index');
    Route::post('/admin/menus', [AdminMenuController::class, 'store'])->name('admin.menus.store');
    Route::get('/admin/menus/{id}', [AdminMenuController::class, 'show'])->name('admin.menus.show');
    Route::get('/admin/menus/{id}/edit', [AdminMenuController::class, 'edit'])->name('admin.menus.edit');
    Route::put('/admin/menus/{id}', [AdminMenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('/admin/menus/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menus.destroy');

    // Commandes et Avis
    Route::get('/admin/commandes', [AdminDashboard::class, 'commandes'])->name('admin.commandes.index');
    Route::get('/admin/avis', [AdminDashboard::class, 'avis'])->name('admin.avis.index');
});