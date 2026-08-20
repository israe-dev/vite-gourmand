@extends('layouts.main-site')

@section('title', 'Connexion Espace Client | Vite & Gourmand')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card p-4 shadow-sm border-0 rounded-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <h1 class="h3 font-serif fw-bold" style="color: var(--marron-doux);">Espace de Connexion</h1>
            <p class="text-muted small">Accessible aux Utilisateurs, Employés et Administrateur.</p>
        </div>

       <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label small">Identifiant de connexion (Votre email)</label>
                <input type="email" name="email" class="form-control" required placeholder="exemple@mail.com">
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label small">Mot de passe</label>
                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--vert-sauge); font-size: 0.8rem;">Mot de passe oublié ?</a>
                </div>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-dark w-100 mt-3 py-2 rounded-pill" style="background-color: var(--marron-doux);">
                Se connecter
            </button>
        </form>
    </div>
</div>
@endsection