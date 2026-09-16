<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        if ($commande->statut !== 'terminée') {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Vous ne pouvez donner un avis que sur une commande terminée.']);
        }

        if ($commande->avis()->exists()) {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Vous avez déjà donné un avis pour cette commande.']);
        }

        $request->validate([
            'note' => ['required', 'integer', 'between:1,5'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

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
