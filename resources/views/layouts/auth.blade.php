@extends('layouts.main-site')

@section('title', 'Création de Compte | Vite & Gourmand')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100%; padding: 40px 20px;">
    <div style="max-width: 600px; width: 100%; background-color: #fdfbf7; padding: 40px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eae5de;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 1.75rem; font-weight: bold; color: #5a3d28; margin-bottom: 10px;">Rejoindre les Gourmands</h1>
            <p style="color: #6c757d; font-size: 0.875rem; line-height: 1.4;">Créez votre compte utilisateur pour mémoriser vos adresses de livraison à Bordeaux et suivre vos réservations en temps réel.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                
                <div style="flex: 1; min-width: 250px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Nom</label>
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required placeholder="Ex : Martin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('nom')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex: 1; min-width: 250px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Prénom</label>
                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required placeholder="Ex : Julie" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('prenom')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="width: 100%;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Numéro de Téléphone Mobile (GSM)</label>
                    <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" required placeholder="Ex : 0612345678" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('telephone')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="width: 100%;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Adresse Postale Principale</label>
                    <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}" required placeholder="Numéro, rue, code postal et ville" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('adresse')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="width: 100%;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Adresse Email (Sert d'identifiant)</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="votre-adresse@mail.com" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('email')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="width: 100%;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Mot de passe hautement sécurisé</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                    @error('password')
                        <div style="color: #dc3545; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                    <div style="font-size: 0.75rem; color: #6c757d; margin-top: 4px;">Sécurité requise par l'infrastructure : 10 caractères minimum contenant obligatoirement 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.</div>
                </div>

                <div style="width: 100%;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #333;">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Répétez votre mot de passe" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;">
                </div>

            </div>

            <button type="submit" style="width: 100%; margin-top: 25px; padding: 12px; background-color: #5a3d28; color: white; border: none; border-radius: 50px; font-weight: 600; cursor: pointer;">
                Créer mon compte utilisateur
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <small style="color: #6c757d;">Déjà un compte ? <a href="{{ route('login') }}" style="color: #7b8b6f; text-decoration: none; font-weight: 600;">Se connecter</a></small>
        </div>
    </div>
</div>
@endsection