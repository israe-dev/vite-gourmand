@extends('layouts.main-site')

@section('title', 'Conditions Générales de Vente | Vite & Gourmand')

@section('content')
<div class="container py-5" style="background-color: #FFFDF8; min-height: 70vh;">
    <h1 class="display-5 font-serif fw-bold mb-5" style="color: var(--marron-doux); font-family: 'Playfair Display', serif;">Conditions Générales de Vente (CGV)</h1>
    
    <div class="row text-muted" style="line-height: 1.8;">
        <div class="col-10">
            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">1. Objet</h3>
            <p>Les présentes CGV régissent les relations contractuelles entre Vite & Gourmand et ses clients pour toutes les commandes de menus et prestations de traiteur passées via l'application.</p>

            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">2. Livraison et Frais</h3>
            <p>La livraison est effectuée à la date et heure convenues lors de la commande. Conformément aux règles de l'établissement, une tarification spécifique s'applique hors de Bordeaux : une facturation fixe de 5 euros, majorée de 0,59 centime par kilomètre parcouru s'applique pour toute livraison en dehors de la ville de Bordeaux.</p>

            <h3 class="h5 fw-bold mt-4" style="color: var(--vert-sauge);">3. Restitution du matériel</h3>
            <p>En cas de prêt de matériel, celui-ci doit être restitué sous 10 jours ouvrés. À défaut de restitution dans ce délai, des frais de 600 euros seront appliqués, comme stipulé par le règlement de l'entreprise.</p>
        </div>
    </div>
</div>
@endsection