<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Enregistre l'avis laissé par le client sur une commande terminée
    public function store(Request $request, $id)
    {
        // On s'assure que la commande appartient bien au client connecté
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        // Petite vérif : la commande doit être terminée pour recevoir un avis
        if ($commande->statut !== 'terminée') {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Vous ne pouvez donner un avis que sur une commande terminée.']);
        }

        // On bloque si un avis a déjà été posté pour cette commande
        if ($commande->avis()->exists()) {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Vous avez déjà donné un avis pour cette commande.']);
        }

        $request->validate([
            'note' => ['required', 'integer', 'between:1,5'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        // Création effective de l'avis en base de données
        Avis::create([
            'note' => $request->input('note'),
            'description' => $request->input('description'),
            'statut' => 'publié',
            'commande_id' => $commande->id,
        ]);

        return redirect()->route('customer.order-details', $commande->id)
            ->with('success', 'Merci pour votre avis !');
    }
}