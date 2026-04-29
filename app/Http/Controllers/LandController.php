<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Land::with('owner')->where('status', 'disponible');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                // Recherche dans la localisation, le titre (sachant que les gens y mettent souvent la superficie, ex: '500m2') et la description
                $sub->where('location', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price_cfa', '<=', $request->max_price);
        }

        $lands = $query->latest()->get();
        return view('lands.index', compact('lands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_cfa' => 'required|numeric|min:0',
            'location' => 'required|string',
            'coordinates' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $land = new Land($validated);
        $land->user_id = Auth::id();
        $land->status = 'disponible';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lands', 'public');
            $land->image_path = $path;
        }

        $land->save();

        return redirect()->route('dashboard')->with('success', 'Terrain mis en vente avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Land $land)
    {
        $land->loadMissing('owner');
        return view('lands.show', compact('land'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Land $land)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if ($land->user_id !== Auth::id()) {
            abort(403);
        }
        return view('lands.edit', compact('land'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_cfa' => 'required|numeric|min:0',
            'location' => 'required|string',
            'coordinates' => 'nullable|string',
            'status' => 'required|string|in:disponible,en_attente,vendu',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($land->image_path) {
                Storage::disk('public')->delete($land->image_path);
            }
            $path = $request->file('image')->store('lands', 'public');
            $land->image_path = $path;
        }

        $land->update(array_merge($validated, ['image_path' => $land->image_path]));

        return redirect()->route('dashboard')->with('success', 'Terrain mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            abort(403);
        }

        if ($land->image_path) {
            Storage::disk('public')->delete($land->image_path);
        }

        $land->delete();

        return redirect()->route('dashboard')->with('success', 'Annonce supprimée.');
    }

    /**
     * Display user dashboard.
     */
    public function dashboard()
    {
        $myLands = Land::where('user_id', Auth::id())->latest()->get();
        return view('lands.dashboard', compact('myLands'));
    }
}
