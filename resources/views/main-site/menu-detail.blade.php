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
        </ol>
    </nav>

    <div class="row g-5 mt-2 align-items-stretch">
        <!-- COLONNE DE GAUCHE : CARROUSEL (HAUTEUR 580px) -->
        <div class="col-md-6">
            <div id="menuCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden h-100" data-bs-ride="carousel" style="min-height: 580px;">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <img src="https://images.pexels.com/photos/5037609/pexels-photo-5037609.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Plat Principal">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="https://images.pexels.com/photos/33419112/pexels-photo-33419112.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Entrée">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="https://images.pexels.com/photos/39388384/pexels-photo-39388384.jpeg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Dessert">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </div>

        <!-- COLONNE DE DROITE : INFORMATIONS ET BOUTON ALIGNÉS -->
        <div class="col-md-6 d-flex flex-column justify-content-between">
            <div>
                <span class="badge mb-2" style="background-color: var(--vert-sauge);">Régime : Classique</span>
                <span class="badge bg-secondary mb-2">Thème : Événement</span>
                
                <h1 class="display-6 font-serif mb-3" style="color: var(--marron-doux);">Menu Terroir & Tradition</h1>
                <p class="lead">Une formule gastronomique authentique préparée à la commande par Julie et José.</p>

                <div class="condition-alert p-3 my-3">
                    <h5 class="h6 font-serif text-warning-dark mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Conditions obligatoires de ce menu :</h5>
                    <p class="small mb-0"><strong>Délai requis :</strong> Ce menu nécessite une réservation obligatoire au minimum <strong>48 heures à l'avance</strong>. <br>
                    <strong>Précautions de stockage :</strong> À conserver au réfrigérateur entre 2°C et 4°C dès réception jusqu'au moment de la dégustation.</p>
                </div>

                <div class="my-3">
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
            </div>

            <div>
                <div class="card p-3 bg-light border-0 rounded-3 mt-3">
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

                <a href="/order/create?menu=1" class="btn w-100 mt-3 py-3 rounded-pill shadow-sm" style="background-color: var(--marron-doux); color: #ffffff !important; border: none; font-weight: 500;">
                    <i class="bi bi-cart-plus-fill me-2"></i> Commander ce Menu
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
