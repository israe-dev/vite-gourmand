@extends('layouts.main-site')

@section('title', 'Mot de passe oublié | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8; min-height: 65vh;">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h1 class="h2 font-serif fw-bold text-center mb-3" style="color: var(--anthracite); font-family: 'Playfair Display', serif;">Mot de passe oublié</h1>
                <p class="text-muted text-center small mb-4">
                    Saisissez votre adresse e-mail. Nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>
                
                <form action="{{ route('password.email') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="nom@exemple.com">
                        @error('email')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm mb-4" style="background-color: var(--vert-sauge); border-radius: 30px;">
                        Envoyer le lien de réinitialisation
                    </button>

                    <p class="text-center small mb-0">
                        <a href="{{ route('login') }}" style="color: #D96C4A; font-weight: 600; text-decoration: none;">
                            <i class="bi bi-arrow-left me-1"></i> Retour à la connexion
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection