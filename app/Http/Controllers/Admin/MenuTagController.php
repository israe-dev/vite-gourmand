<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allergene;
use App\Models\Regime;
use Illuminate\Http\Request;

class MenuTagController extends Controller
{
    public function index() 
    { 
        $allergenes = Allergene::all();
        $regimes = Regime::all();

        return view('admin.allergenes', compact('allergenes', 'regimes')); 
    }

    public function storeAllergene(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50|unique:allergenes,libelle'
        ]);

        Allergene::create(['libelle' => $request->libelle]);

        return redirect()->back()->with('success', 'Allergène ajouté avec succès.');
    }

    public function storeRegime(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50|unique:regimes,libelle'
        ]);

        Regime::create(['libelle' => $request->libelle]);

        return redirect()->back()->with('success', 'Régime alimentaire ajouté avec succès.');
    }
}