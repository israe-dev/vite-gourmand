<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use App\Models\Allergene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
    public function index() 
    { 
        // Optimisation de requête : On segmente directement au niveau SQL pour les onglets
        $entrees = Plat::with('allergenes')->where('type', 'entree')->get();
        $platsPrincipaux = Plat::with('allergenes')->where('type', 'plat')->get();
        $desserts = Plat::with('allergenes')->where('type', 'dessert')->get();
        
        $allergenes = Allergene::all();

        return view('admin.plats', compact('entrees', 'platsPrincipaux', 'desserts', 'allergenes')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'type' => 'required|in:entree,plat,dessert',
            'description' => 'nullable|string',
            'quantite' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation de l'image
            'allergenes' => 'nullable|array'
        ]);

        // Gestion de l'upload du fichier photo
        $pathPhoto = null;
        if ($request->hasFile('photo')) {
            // Stocke l'image dans storage/app/public/plats et récupère le chemin abrégé
            $pathPhoto = $request->file('photo')->store('plats', 'public');
        }

        $plat = Plat::create([
            'nom' => $request->nom,
            'type' => $request->type,
            'description' => $request->description,
            'quantite' => $request->quantite,
            'photo' => $pathPhoto, // Sauvegarde du chemin en BDD
        ]);

        if ($request->has('allergenes')) {
            $plat->allergenes()->sync($request->allergenes);
        }

        return redirect()->back()->with('success', 'Le plat a été ajouté aux cuisines avec ses stocks et son illustration !');
    }

    public function destroy($id)
    {
        $plat = Plat::findOrFail($id);
        
        // Sécurité : Suppression physique du fichier image s'il existe
        if ($plat->photo && Storage::disk('public')->exists($plat->photo)) {
            Storage::disk('public')->delete($plat->photo);
        }

        // Nettoyage de la table pivot avant suppression du plat
        $plat->allergenes()->detach();
        $plat->delete();

        return redirect()->back()->with('success', 'Le plat ainsi que son illustration ont été supprimés du catalogue.');
    }
}