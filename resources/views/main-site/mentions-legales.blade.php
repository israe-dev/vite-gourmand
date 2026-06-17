@extends('layouts.main-site')

@section('title', 'Mentions Légales | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8; min-height: 70vh;">
    <h1 class="display-5 font-serif fw-bold mb-5" style="color: var(--marron-doux); font-family: 'Playfair Display', serif;">Mentions Légales</h1>
    
    <div class="row text-muted" style="line-height: 1.8;">
        <div class="col-10">
            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">1. Éditeur du site</h3>
            <p>Le site internet <strong>Vite & Gourmand</strong> est édité par l'entreprise de traiteur Vite & Gourmand, représentée par Julie et José, dont le siège social est situé au 123 Cours de la Marne, 33000 Bordeaux.</p>

            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">2. Hébergement</h3>
            <p>Ce site est hébergé en environnement local et de démonstration dans le cadre d'une certification professionnelle (Titre DWWM).</p>

            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">3. Propriété intellectuelle</h3>
            <p>Tous les éléments graphiques, textuels et visuels présents sur ce site sont la propriété exclusive de Vite & Gourmand ou font l'objet d'une autorisation d'utilisation.</p>
        </div>
    </div>
</div>
@endsection