@extends('layouts.main-site')

@section('title', 'Passer ma commande | Vite & Gourmand')

@section('content')
<div class="container py-5">
    <h1 class="font-serif mb-4" style="color: var(--marron-doux);">Validation de votre prestation</h1>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <input type="hidden" name="menu_id" value="1">
        <input type="hidden" name="prix_menu" value="45.00">

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <h3 class="h5 font-serif mb-4 text-muted border-bottom pb-2">1. Informations Client (Auto-complétées)</h3>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nom</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->nom ?? 'Non renseigné' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Prénom</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->prenom ?? 'Non renseigné' }}" readonly>
                        </div>
                        <div class="col-md-10">
                            <label class="form-label small text-muted">Téléphone GSM</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->telephone ?? '06 00 00 00 00' }}" readonly>
                        </div>
                    </div>

                    <h3 class="h5 font-serif mb-4 text-muted border-bottom pb-2">2. Détails de la Prestation Logistique</h3>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small">Lieu exact de livraison / événement</label>
                            <input type="text" name="lieu_livraison" class="form-control" placeholder="Adresse complète (ex: 12 Rue Sainte-Catherine, 33000 Bordeaux)" required>
                            <span class="text-muted d-block mt-1 style-italic" style="font-size:0.75rem;">Frais : gratuit dans Bordeaux intra-muros. Hors Bordeaux : forfait fixe de 5€ majoré de 0.59€/km.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Date demandée</label>
                            <input type="date" name="date_prestation" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Heure souhaitée</label>
                            <input type="time" name="heure_livraison" class="form-control" required>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small font-weight-bold">Nombre de convives</label>
                            <input type="number" name="nombre_personnes" class="form-control" min="10" value="10" style="border: 2px solid var(--vert-sauge);" required>
                            <span class="text-muted d-block mt-1" style="font-size:0.75rem;">Minimum requis pour ce menu : 10 personnes.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card p-4 border-0 shadow-sm rounded-4 text-white" style="background-color: var(--marron-doux);">
                    <h3 class="h5 font-serif mb-4 border-bottom pb-2 text-center" style="color: var(--beige-creme);">Votre Devis en temps réel</h3>
                    
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Menu sélectionné :</span>
                        <span class="text-end"><strong>Terroir & Tradition</strong></span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Prix unitaire de base :</span>
                        <span>45.00 € / pers.</span>
                    </div>
                    
                    <hr style="background-color: rgba(255,255,255,0.2);">
                    
                    <div class="mb-2 d-flex justify-content-between text-muted-white small">
                        <span>Sous-total Menus (10 x 45€) :</span>
                        <span>450.00 €</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between text-success-light small">
                        <span>Remise ECF exclusive (+5 pers.) :</span>
                        <span class="text-success">- 0.00 € (0%)</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between small">
                        <span>Frais logistiques de transport :</span>
                        <span>En attente de l'adresse</span>
                    </div>

                    <hr style="background-color: rgba(255,255,255,0.2);">

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">Montant Global TTC :</span>
                        <span class="h3 mb-0" style="color: var(--orange-brand);"><strong>450.00 €</strong></span>
                    </div>

                    <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold" style="background-color: var(--orange-brand); color: white; border: none;">
                        Confirmer et réserver ma date
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection