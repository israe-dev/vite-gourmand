<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Menu;
use App\Services\DeliveryFeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Affiche la liste des commandes du client connecté
    public function index()
    {
        $commandes = Commande::where('utilisateur_id', Auth::id())
            ->orderByDesc('date_commande')
            ->get();

        return view('customer.orders', compact('commandes'));
    }

    // Affiche le formulaire pour créer une nouvelle commande
    public function create(Request $request)
    {
        $menus = Menu::orderBy('titre')->get();
        $selectedMenuId = $request->query('menu');

        return view('customer.create', compact('menus', 'selectedMenuId'));
    }

    // Enregistre la nouvelle commande en base de données avec gestion des stocks et paiement
    public function store(Request $request, DeliveryFeeService $deliveryService)
    {
        $validated = $request->validate([
            'menu_id'          => 'required|exists:menus,id',
            'nombre_personnes' => 'required|integer|min:1',
            'date_prestation'  => 'required|date|after_or_equal:today',
            'heure_livraison'  => 'required',
            'lieu_livraison'   => 'required|string|max:500',
            'complement_adresse' => 'nullable|string|max:255',
        ]);

        try {
            $deliveryData = $deliveryService->calculate($validated['lieu_livraison']);
        } catch (\Exception $e) {
            return back()->withErrors(['lieu_livraison' => $e->getMessage()])->withInput();
        }

        $adresseStockee = trim($validated['lieu_livraison']);
        if (!empty($validated['complement_adresse'])) {
            $adresseStockee = trim($validated['complement_adresse']) . ' — ' . $adresseStockee;
        }

        return DB::transaction(function () use ($validated, $deliveryData, $adresseStockee) {
            $menu = Menu::where('id', $validated['menu_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['nombre_personnes'] < $menu->nb_personne_minimum) {
                return back()->withErrors([
                    'nombre_personnes' => "Le nombre minimum de personnes pour ce menu est de {$menu->nb_personne_minimum}."
                ])->withInput();
            }

            if ($menu->quantite_restante < $validated['nombre_personnes']) {
                return back()->withErrors([
                    'nombre_personnes' => "Stock insuffisant pour ce menu (restant : {$menu->quantite_restante})."
                ])->withInput();
            }

            $prixMenu = $menu->prix_par_personne * $validated['nombre_personnes'];
            if (($validated['nombre_personnes'] - $menu->nb_personne_minimum) >= 5) {
                $prixMenu *= 0.90;
            }
            $prix_menu_arrondi = round($prixMenu, 2);
            $prix_livraison = $deliveryData['prix_livraison'];
            $prix_materiel = 0;
            $total = round($prix_menu_arrondi + $prix_livraison + $prix_materiel, 2);

            $commande = Commande::create([
                'date_commande'    => now()->toDateString(),
                'date_prestation'  => $validated['date_prestation'],
                'heure_livraison'  => $validated['heure_livraison'],
                'lieu_livraison'   => $adresseStockee,
                'nombre_personnes' => $validated['nombre_personnes'],
                'prix_menu'        => $prix_menu_arrondi,
                'prix_livraison'   => $prix_livraison,
                'prix_materiel'    => $prix_materiel,
                'total'            => $total,
                'payment_status'   => 'pending',
                'statut'           => 'en attente',
                'utilisateur_id'   => Auth::id(),
                'menu_id'          => $menu->id,
            ]);

            $menu->decrement('quantite_restante', $validated['nombre_personnes']);

            // Initialise la session de paiement Stripe si la clé est configurée
            if (!empty(config('services.stripe.secret'))) {
                try {
                    $stripeClient = new \Stripe\StripeClient(config('services.stripe.secret'));

                    $successUrl = route('customer.payment.success', ['id' => $commande->id]) . '?session_id={CHECKOUT_SESSION_ID}';
                    $cancelUrl = route('customer.payment.cancel', ['id' => $commande->id]);

                    $session = $stripeClient->checkout->sessions->create([
                        'payment_method_types' => ['card'],
                        'mode' => 'payment',
                        'line_items' => [[
                            'price_data' => [
                                'currency' => config('services.stripe.currency', 'eur'),
                                'product_data' => ['name' => "Commande #{$commande->id}"],
                                'unit_amount' => (int) round($total * 100),
                            ],
                            'quantity' => 1,
                        ]],
                        'client_reference_id' => (string) $commande->id,
                        'metadata' => [
                            'commande_id' => (string) $commande->id,
                            'user_id' => (string) Auth::id(),
                        ],
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ]);

                    $commande->update(['payment_provider_id' => $session->id]);

                    return redirect($session->url);
                } catch (\Exception $e) {
                    return redirect()->route('customer.orders')
                        ->withErrors(['payment' => 'Erreur Stripe : ' . $e->getMessage()]);
                }
            }

            return redirect()->route('customer.orders')
                ->with('success', 'Votre commande a été enregistrée avec succès.');
        });
    }

    // Affiche le détail d'une commande spécifique
    public function show($id)
    {
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        return view('customer.show', compact('commande'));
    }

    // Affiche le formulaire de modification d'une commande
    public function edit($id)
    {
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        if ($commande->statut !== 'en attente') {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Seules les commandes en attente peuvent être modifiées.']);
        }

        $menus = Menu::orderBy('titre')->get();

        return view('customer.edit', compact('commande', 'menus'));
    }

    // Met à jour une commande existante et ajuste les stocks en conséquence
    public function update(Request $request, $id, DeliveryFeeService $deliveryService)
    {
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        if ($commande->statut !== 'en attente') {
            return redirect()->route('customer.orders')
                ->withErrors(['error' => 'Cette commande ne peut plus être modifiée.']);
        }

        $validated = $request->validate([
            'menu_id'          => 'required|exists:menus,id',
            'nombre_personnes' => 'required|integer|min:1',
            'date_prestation'  => 'required|date|after_or_equal:today',
            'heure_livraison'  => 'required',
            'lieu_livraison'   => 'required|string|max:500',
        ]);

        try {
            $deliveryData = $deliveryService->calculate($validated['lieu_livraison']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['lieu_livraison' => $e->getMessage()])->withInput();
        }

        return DB::transaction(function () use ($validated, $deliveryData, $commande) {
            $newMenu = Menu::where('id', $validated['menu_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['nombre_personnes'] < $newMenu->nb_personne_minimum) {
                return back()->withErrors([
                    'nombre_personnes' => "Le nombre minimum de personnes pour ce menu est de {$newMenu->nb_personne_minimum}."
                ])->withInput();
            }

            $oldMenuId = $commande->menu_id;
            $oldPersons = $commande->nombre_personnes;

            if ($oldMenuId === $newMenu->id) {
                $diff = $validated['nombre_personnes'] - $oldPersons;

                if ($diff > 0 && $newMenu->quantite_restante < $diff) {
                    return back()->withErrors([
                        'nombre_personnes' => "Stock insuffisant (restant : {$newMenu->quantite_restante})."
                    ])->withInput();
                }

                if ($diff > 0) {
                    $newMenu->decrement('quantite_restante', $diff);
                } elseif ($diff < 0) {
                    $newMenu->increment('quantite_restante', abs($diff));
                }
            } else {
                $oldMenu = Menu::find($oldMenuId);
                if ($oldMenu) {
                    $oldMenu->increment('quantite_restante', $oldPersons);
                }

                if ($newMenu->quantite_restante < $validated['nombre_personnes']) {
                    return back()->withErrors([
                        'nombre_personnes' => "Stock insuffisant pour ce menu (restant : {$newMenu->quantite_restante})."
                    ])->withInput();
                }

                $newMenu->decrement('quantite_restante', $validated['nombre_personnes']);
            }

            $prixMenu = $newMenu->prix_par_personne * $validated['nombre_personnes'];
            if (($validated['nombre_personnes'] - $newMenu->nb_personne_minimum) >= 5) {
                $prixMenu *= 0.90;
            }

            $prixMenu = round($prixMenu, 2);
            $prixLivraison = (float) $deliveryData['prix_livraison'];
            $prixMateriel = (float) ($commande->prix_materiel ?? 0);
            $total = round($prixMenu + $prixLivraison + $prixMateriel, 2);

            $commande->update([
                'menu_id'          => $newMenu->id,
                'lieu_livraison'   => $validated['lieu_livraison'],
                'date_prestation'  => $validated['date_prestation'],
                'heure_livraison'  => $validated['heure_livraison'],
                'nombre_personnes' => $validated['nombre_personnes'],
                'prix_menu'        => $prixMenu,
                'prix_livraison'   => $prixLivraison,
                'total'            => $total,
            ]);

            return redirect()->route('customer.order-details', $commande->id)
                ->with('success', 'Votre commande a bien été modifiée.');
        });
    }

    // Annule une commande et remet les places/quantités dans le stock du menu
    public function cancel($id)
    {
        $commande = Commande::where('id', $id)
            ->where('utilisateur_id', Auth::id())
            ->firstOrFail();

        if ($commande->statut !== 'en attente') {
            return redirect()->route('customer.order-details', $commande->id)
                ->withErrors(['error' => 'Seules les commandes en attente peuvent être annulées.']);
        }

        DB::transaction(function () use ($commande) {
            $commande->update(['statut' => 'annulée']);

            $menu = Menu::find($commande->menu_id);
            if ($menu && isset($menu->quantite_restante)) {
                $menu->increment('quantite_restante', $commande->nombre_personnes);
            }
        });

        return redirect()->route('customer.orders')
            ->with('success', 'La commande a bien été annulée.');
    }

    // Estime les frais de livraison en AJAX selon l'adresse saisie
    public function estimateFee(Request $request, DeliveryFeeService $deliveryService)
    {
        $request->validate([
            'lieu_livraison' => 'required|string',
        ]);

        try {
            $result = $deliveryService->calculate($request->lieu_livraison);

            return response()->json([
                'success'        => true,
                'prix_livraison' => number_format($result['prix_livraison'], 2, ',', ' '),
                'distance_km'    => $result['distance_km'],
                'zone'           => $result['zone'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}