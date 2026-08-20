@extends('layouts.main-site')

@section('title', 'Nos Menus | Vite & Gourmand')

@section('content')
<style>
    .menu-card { border: none; border-radius: 15px; overflow: hidden; background: white; transition: transform 0.3s ease; }
    .menu-card:hover { transform: translateY(-5px); }
    .card-carousel { height: 250px; }
    .card-carousel img { height: 250px; width: 100%; object-fit: cover; }
    .badge-custom { position: absolute; top: 15px; left: 15px; z-index: 10; background: #6B8E23; color: white; padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; }
    .btn-details { background-color: #E2725B; color: white; border: none; font-weight: 600; padding: 10px 0; border-radius: 6px; width: 100%; transition: 0.3s; }
    .btn-details:hover { background-color: #c55a39; color: white; }
</style>

<section class="py-5 bg-light">
    <div class="container">
        
        {{-- En-tête de la page --}}
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold" style="font-family: 'Playfair Display', serif;">Découvrez notre Carte</h2>
            <p class="text-muted">Explorez nos créations culinaires et filtrez-les selon vos envies en temps réel.</p>
        </div>

        {{-- FORMULAIRE DE FILTRAGE DYNAMIQUE --}}
        <div class="card shadow-sm p-4 mb-5 bg-white border-0" style="border-radius: 15px;">
            <form id="filter-form" action="{{ route('menus') }}" method="GET" class="row g-3">
                
                <div class="col-md-4">
                    <label for="recherche" class="form-label fw-bold text-secondary">Rechercher un menu</label>
                    <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Ex: Jardin, Éclat, Salade...">
                </div>

                <div class="col-md-4">
                    <label for="theme_id" class="form-label fw-bold text-secondary">Thématique</label>
                    <select name="theme_id" id="theme_id" class="form-select">
                        <option value="">Tous les thèmes</option>
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="prix_max" class="form-label fw-bold text-secondary">Prix max par personne</label>
                    <input type="number" name="prix_max" id="prix_max" class="form-control" placeholder="Ex: 30" min="0" step="0.5">
                </div>

            </form>
        </div>

        {{-- GRILLE DES MENUS (Mise à jour par JS) --}}
        <div class="row g-4" id="menus-container">
            {{-- Inclusion directe des cartes lors du premier chargement --}}
            @include('partials.menu-cards')
        </div>

    </div>
</section>

{{-- SCRIPT FETCH POUR LE FILTRAGE EN TEMPS RÉEL --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const container = document.getElementById('menus-container');

    function fetchMenus() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`${form.action}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Remplace l'ancienne liste de cartes par la nouvelle filtrée
            container.innerHTML = data.html;
        })
        .catch(error => console.error('Erreur lors du filtrage :', error));
    }

    // Écoute les frappes clavier (input) et les changements de sélection (change)
    form.addEventListener('input', fetchMenus);
    form.addEventListener('change', fetchMenus);
});
</script>
@endsection