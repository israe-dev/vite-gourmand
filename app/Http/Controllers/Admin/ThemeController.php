<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        // Récupère tous les thèmes triés par nom
        $themes = Theme::orderBy('libelle', 'asc')->get();
        return view('admin.themes', compact('themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50|unique:themes,libelle',
        ], [
            'libelle.unique' => 'Ce thème existe déjà dans votre catalogue.',
        ]);

        Theme::create([
            'libelle' => $request->libelle
        ]);

        return redirect()->back()->with('success', 'Le thème a été ajouté avec succès !');
    }

    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);
        
        // Sécurité métier : On verra plus tard si on passe les menus liés à NULL 
        // avant de supprimer, mais pour l'instant on supprime le thème proprement.
        $theme->delete();

        return redirect()->back()->with('success', 'Le thème a été retiré du catalogue.');
    }
}