@extends('layouts.main-site')

@section('title', 'Création de Compte | Vite & Gourmand')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card p-4 shadow-sm border-0 rounded-4" style="max-width: 600px; width: 100%; background-color: var(--beige-creme);">
        <div class="text-center mb-4">
            <h1 class="h3 font-serif fw-bold" style="color: var(--marron-doux);">Rejoindre les Gourmands</h1>
            <p class="text-muted small">Créez votre compte utilisateur pour mémoriser vos adresses de livraison à Bordeaux et suivre vos réservations en temps réel.</p>
        </div>

        <form action="/register" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Nom</label>
                    <input type="text" name="nom" class="form-control" required placeholder="Ex : Martin">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required placeholder="Ex : Julie">
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Numéro de Téléphone Mobile (GSM)</label>
                    <input type="tel" name="telephone" class="form-control" required placeholder="Ex : 0612345678">
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Adresse Postale Principale</label>
                    <input type="text" name="adresse" class="form-control" required placeholder="Numéro, rue, code postal et ville">
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Adresse Email (Sert d'identifiant)</label>
                    <input type="email" name="email" class="form-control" required placeholder="votre-adresse@mail.com">
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Mot de passe hautement sécurisé</label>
                    <input type="password" name="password" class="form-control" required minlength="10">
                    <div class="form-text text-muted" style="font-size:0.75rem;">Sécurité requise par l'infrastructure : 10 caractères minimum contenant obligatoirement 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.</div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100 mt-4 py-2 rounded-pill" style="background-color: var(--marron-doux);">
                Créer mon compte utilisateur
            </button>
        </form>
    </div>
</div>
@endsection