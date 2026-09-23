<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Gère le retour après un paiement Stripe réussi
    public function success(Request $request, $id)
    {
        $sessionId = $request->query('session_id');
        if (empty($sessionId)) {
            return redirect()->route('customer.orders')->withErrors(['payment' => 'Session Stripe manquante.']);
        }

        $commande = Commande::where('id', $id)->where('utilisateur_id', Auth::id())->firstOrFail();

        if (empty(config('services.stripe.secret'))) {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['payment' => 'Configuration Stripe manquante.']);
        }

        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId, []);

            // Vérifie que la session correspond bien à cette commande
            if (($session->client_reference_id ?? null) != (string)$commande->id) {
                return redirect()->route('customer.orders')->withErrors(['payment' => 'Session Stripe invalide pour cette commande.']);
            }

            // Vérifie si le paiement a bien été validé (via la session ou le payment intent)
            $paid = false;
            if (!empty($session->payment_status) && $session->payment_status === 'paid') {
                $paid = true;
            } elseif (!empty($session->payment_intent)) {
                $pi = $stripe->paymentIntents->retrieve($session->payment_intent, []);
                if (!empty($pi->status) && $pi->status === 'succeeded') {
                    $paid = true;
                }
            }

            if ($paid) {
                // Met à jour les statuts de paiement et de la commande
                $commande->update([
                    'payment_status' => 'paid',
                    'status' => 'en_attente_validation',
                    'payment_provider_id' => $sessionId,
                    'payment_method' => isset($session->payment_method_types[0]) ? $session->payment_method_types[0] : null,
                    'paid_at' => now(),
                ]);

                return view('customer.payment-success', ['commandeId' => $commande->id]);
            }

            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['payment' => 'Le paiement n\'a pas été confirmé.']);
        } catch (\Exception $e) {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['payment' => 'Erreur lors de la vérification du paiement : ' . $e->getMessage()]);
        }
    }

    // Gère le retour lorsque le client annule le paiement sur Stripe
    public function cancel(Request $request, $id)
    {
        $commande = Commande::where('id', $id)->where('utilisateur_id', Auth::id())->firstOrFail();

        $commande->update(['payment_status' => 'cancelled']);

        // Affiche la vue dédiée à l'annulation du paiement
        return view('customer.payment-cancel', ['commandeId' => $commande->id]);
    }
}