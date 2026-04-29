<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;

// --- Page d'accueil (liste publique des terrains) ---
Route::get('/', [LandController::class, 'index'])->name('lands.index');

// --- Routes Authentifiées (Utilisateur Polyvalent) ---
Route::middleware(['auth'])->group(function () {

    // Tableau de bord
    Route::get('/dashboard', [LandController::class, 'dashboard'])->name('dashboard');

    // Gestion des annonces – les routes nommées (create, store, edit, update, destroy)
    // doivent être AVANT le wildcard /lands/{land}
    Route::resource('lands', LandController::class)->except(['index', 'show']);

    // Logique de Transaction (Achat/Mutation)
    Route::get('/lands/{land}/checkout', [TransactionController::class, 'checkout'])->name('lands.checkout');
    Route::post('/lands/{land}/purchase', [TransactionController::class, 'purchase'])->name('lands.purchase');
    Route::get('/lands/{land}/invoice', [TransactionController::class, 'invoice'])->name('lands.invoice');

    // Remise en vente
    Route::patch('/lands/{land}/relist', [TransactionController::class, 'relist'])->name('lands.relist');

    // Profil Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Vue détail terrain (publique) – APRÈS les routes resource pour éviter le conflit avec /lands/create ---
Route::get('/lands/{land}', [LandController::class, 'show'])->name('lands.show');

// --- Routes Administration ---
Route::middleware(['auth', 'can:admin-access'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::patch('/lands/{land}/verify', [AdminController::class, 'verify'])->name('admin.lands.verify');
});

require __DIR__.'/auth.php';
