@extends('layouts.main-site')

@section('title', 'Créer un compte | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h1 class="h2 font-serif fw-bold text-center mb-4" style="color: var(--marron-doux); font-family: 'Playfair Display', serif;">Créer un compte</h1>
                <p class="text-muted text-center small mb-4">Rejoignez Vite & Gourmand pour commander vos menus personnalisés à Bordeaux.</p>

                <form action="{{ route('register') }}" method="POST" novalidate>
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label small fw-bold text-muted">Nom *</label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}" 
                                   required>
                            @error('nom')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label small fw-bold text-muted">Prénom *</label>
                            <input type="text" 
                                   class="form-control @error('prenom') is-invalid @enderror" 
                                   id="prenom" 
                                   name="prenom" 
                                   value="{{ old('prenom') }}" 
                                   required>
                            @error('prenom')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail *</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gsm" class="form-label small fw-bold text-muted">Numéro de GSM *</label>
                        <input type="tel" 
                               class="form-control @error('gsm') is-invalid @enderror" 
                               id="gsm" 
                               name="gsm" 
                               placeholder="0600000000" 
                               value="{{ old('gsm') }}" 
                               required>
                        @error('gsm')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="adresse_postale" class="form-label small fw-bold text-muted">Adresse postale complète *</label>
                        <textarea class="form-control @error('adresse_postale') is-invalid @enderror" 
                                  id="adresse_postale" 
                                  name="adresse_postale" 
                                  rows="2" 
                                  placeholder="N°, rue, code postal et ville" 
                                  required>{{ old('adresse_postale') }}</textarea>
                        @error('adresse_postale')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-muted">Mot de passe *</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
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