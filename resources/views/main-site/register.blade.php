@extends('layouts.main-site')

@section('title', 'Créer un compte | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h1 class="h2 font-serif fw-bold text-center mb-4" style="color: var(--marron-doux); font-family: 'Playfair Display', serif;">Créer un compte</h1>
                <p class="text-muted text-center small mb-4">Rejoignez Vite & Gourmand pour commander vos menus personnalisés à Bordeaux.</p>

                <form action="#" method="POST" novalidate>
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label small fw-bold text-muted">Nom *</label>
                            <input type="text" class="form-control" id="nom" name="nom" required [cite: 90]>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label small fw-bold text-muted">Prénom *</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required [cite: 90]>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail *</label>
                        <input type="email" class="form-control" id="email" name="email" required [cite: 92]>
                    </div>

                    <div class="mb-3">
                        <label for="gsm" class="form-label small fw-bold text-muted">Numéro de GSM *</label>
                        <input type="tel" class="form-control" id="gsm" name="gsm" placeholder="0600000000" required [cite: 91]>
                    </div>

                    <div class="mb-3">
                        <label for="adresse_postale" class="form-label small fw-bold text-muted">Adresse postale complète *</label>
                        <textarea class="form-control" id="adresse_postale" name="adresse_postale" rows="2" placeholder="N°, rue, code postal et ville" required [cite: 92]></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-muted">Mot de passe *</label>
                       <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                       <div class="form-text text-muted xsmall mt-1" style="font-size: 0.8rem;">
                            <i class="bi bi-info-circle-fill me-1" style="color: var(--vert-sauge);"></i>
                            Exigence de sécurité : Minimum 10 caractères, incluant au moins une majuscule, une minuscule, un chiffre et un caractère spécial.
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm mb-3" style="background-color: #D96C4A; border-radius: 30px;">
                        S'inscrire
                    </button>

                    <p class="text-center small text-muted mb-0">
                        Vous avez déjà un compte ? <a href="{{ url('/connexion') }}" style="color: var(--vert-sauge); font-weight: 600;">Connectez-vous</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection