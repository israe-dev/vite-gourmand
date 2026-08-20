@extends('layouts.main-site')

@section('title', 'Réinitialisation du mot de passe | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8; min-height: 65vh;">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h1 class="h2 font-serif fw-bold text-center mb-4" style="color: var(--anthracite); font-family: 'Playfair Display', serif;">Nouveau mot de passe</h1>
                
                <form action="{{ route('password.update') }}" method="POST" novalidate>
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                        @error('email')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold text-muted">Nouveau mot de passe *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label small fw-bold text-muted">Confirmer le nouveau mot de passe *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm mb-3" style="background-color: #D96C4A; border-radius: 30px;">
                        Mettre à jour le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection