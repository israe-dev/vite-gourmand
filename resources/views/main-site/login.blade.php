@extends('layouts.main-site')

@section('title', 'Connexion | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8; min-height: 65vh;">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <h1 class="h2 font-serif fw-bold text-center mb-4" style="color: var(--marron-doux); font-family: 'Playfair Display', serif;">Connexion</h1>
                
                <form action="#" method="POST" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail (Identifiant) *</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="nom@exemple.com" [cite: 97]>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label small fw-bold text-muted mb-0">Mot de passe *</label>
                            <a href="#" class="small text-decoration-none" style="color: var(--vert-sauge); font-size: 0.8rem;" [cite: 98]>Mot de passe oublié ?</a>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required [cite: 97]>
                    </div>

                    <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm mb-4" style="background-color: var(--vert-sauge); border-radius: 30px;">
                        Se connecter
                    </button>

                    <p class="text-center small text-muted mb-0">
                        Nouveau chez Vite & Gourmand ? <a href="{{ url('/inscription') }}" style="color: #D96C4A; font-weight: 600;">Créer un compte</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection