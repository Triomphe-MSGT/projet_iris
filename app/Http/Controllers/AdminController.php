<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Land;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord Admin et la liste des utilisateurs.
     */
    public function index()
    {
        // Récupère tous les utilisateurs sauf l'admin lui-même (sauf si on veut aussi le lister)
        // On charge aussi le nombre de terrains pour l'affichage
        $users = User::withCount('lands')->where('email', '!=', 'admin@iris.com')->latest()->get();
        $totalLands = Land::count();
        
        return view('admin.dashboard', compact('users', 'totalLands'));
    }

    /**
     * Supprime un utilisateur et tous ses terrains
     */
    public function destroyUser(User $user)
    {
        // Empêche l'admin de se supprimer lui-même par inadvertance
        if ($user->email === 'admin@iris.com') {
            return back()->with('error', 'Impossible de supprimer cet administrateur.');
        }

        // Supprimer toutes les images liées aux terrains de cet utilisateur
        foreach ($user->lands as $land) {
            if ($land->image_path) {
                Storage::disk('public')->delete($land->image_path);
            }
        }

        // Supprimer l'utilisateur (la BD cascade normalement les entités si configurée, sinon on le fait via Eloquent event/relations ou ici implicitement)
        // Mais comme on n'a pas mis de cascadeDB (à vérifier), onDelete('cascade') était-il utilisé ?
        // Par sécurité, on utilise ->delete() sur les terrains d'abord.
        $user->lands()->delete();
        $user->delete();

        return back()->with('success', 'Utilisateur et toutes ses données supprimés avec succès.');
    }
}
