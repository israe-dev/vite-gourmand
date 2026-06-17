@extends('layouts.main-site')

@section('title', 'Détail du Menu | Vite & Gourmand')

@section('content')
<style>
    .condition-alert { background-color: #fff3cd; border-left: 5px solid #ffc107; border-radius: 8px; }
    .allergen-badge { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 15px; font-size: 0.8rem; padding: 2px 10px; }
</style>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: var(--vert-sauge);">Accueil</a></li>
            <li class="breadcrumb-item"><a href="/menus" style="color: var(--vert-sauge);">Nos Menus</a></li>
            <li class="breadcrumb-item active" aria-current="page">Menu Terroir & Tradition</li>
        </</ol>
    </nav>

    <div class="row g-5 mt-2">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=700" class="img-fluid rounded-4 shadow-sm mb-3" alt="Plat Principal">
            <div class="row g-2">
                <div class="col-4"><img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&q=80&w=200" class="img-fluid rounded-3" alt="Entrée"></div>
                <div class="col-4"><img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?auto=format&fit=crop&q=80&w=200" class="img-fluid rounded-3" alt="Dessert"></div>
            </div>
        </div>

        <div class="col-md-6">
            <span class="badge mb-2" style="background-color: var(--vert-sauge);">Régime : Classique</span>
            <span class="badge bg-secondary mb-2">Thème : Événement</span>
            
            <h1 class="display-6 font-serif mb-3" style="color: var(--marron-doux);">Menu Terroir & Tradition</h1>
            <p class="lead">Une formule gastronomique authentique préparée à la commande par Julie et José.</p>

            <div class="condition-alert p-3 my-4">
                <h5 class="h6 font-serif text-warning-dark mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Conditions obligatoires de ce menu :</h5>
                <p class="small mb-0"><strong>Délai requis :</strong> Ce menu nécessite une réservation obligatoire au minimum <strong>48 heures à l'avance</strong>. <br>
                <strong>Précautions de stockage :</strong> À conserver au réfrigérateur entre 2°C et 4°C dès réception jusqu'au moment de la dégustation.</p>
            </div>

            <div class="my-4">
                <h4 class="h5 font-serif border-bottom pb-2">Composition de la Formule</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent py-2">
                        <strong>Entrée :</strong> Foie gras de canard mi-cuit, chutney de figues de Gironde
                        <div class="mt-1"><span class="allergen-badge">Sulfites</span></div>
                    </li>
                    <li class="list-group-item bg-transparent py-2">
                        <strong>Plat :</strong> Confit de canard croustillant, écrasé de pommes de terre à l'huile de truffe
                        <div class="mt-1"><span class="allergen-badge">Lactose</span></div>
                    </li>
                    <li class="list-group-item bg-transparent py-2">
                        <strong>Dessert :</strong> Canelés bordelais revisités sur lit de crème anglaise vanillée
                        <div class="mt-1"><span class="allergen-badge">Gluten</span> <span class="allergen-badge">Œufs</span></div>
                    </li>
                </ul>
            </div>

            <div class="card p-3 bg-light border-0 rounded-3 mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">Nombre de personnes minimal : <strong>10</strong></span><br>
                        <span class="text-muted small">Disponibilité restante : <strong class="text-success">5 commandes possibles</strong></span>
                    </div>
                    <div class="text-end">
                        <span class="h3 mb-0 d-block" style="color: var(--orange-brand);"><strong>45.00 €</strong></span>
                        <span class="text-muted small">par personne</span>
                    </div>
                </div>
            </div>

            <a href="/order/create?menu=1" class="btn btn-dark w-100 mt-4 py-3 rounded-pill" style="background-color: var(--marron-doux);">
                <i class="bi bi-cart-plus-fill me-2"></i> Commander ce Menu
            </a>
        </div>
    </div>
</div>
@endsection