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
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required placeholder="Ex : Martin">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Prénom</label>
                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required placeholder="Ex : Julie">
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Numéro de Téléphone Mobile (GSM)</label>
                    <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" required placeholder="Ex : 0612345678">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Adresse Postale Principale</label>
                    <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}" required placeholder="Numéro, rue, code postal et ville">
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Adresse Email (Sert d'identifiant)</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="votre-adresse@mail.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label small">Mot de passe hautement sécurisé</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="text-danger small mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
                    @enderror
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