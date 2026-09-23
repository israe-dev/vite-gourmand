@extends('layouts.main-site')

@section('title', 'Accueil | Vite & Gourmand - Plats Frais et Adaptés')

@section('content')

<!-- Style de la page -->
<style>
    .hero-section {
        padding: 80px 0;
        background-color: #FFFDF8;
    }
    
    .hero-title {
        font-size: 3.5rem;
        line-height: 1.2;
        color: var(--anthracite);
    }

    .btn-hero-primary {
        background-color: #D96C4A;
        color: white;
        font-weight: 600;
        padding: 14px 30px;
        border-radius: 6px;
        border: none;
        transition: background 0.3s;
    }
    .btn-hero-primary:hover {
        background-color: #c55a39;
        color: white;
    }

    .btn-hero-secondary {
        background-color: white;
        color: var(--anthracite);
        font-weight: 600;
        padding: 14px 30px;
        border-radius: 6px;
        border: 1px solid rgba(0,0,0,0.15);
        transition: background 0.3s;
    }
    .btn-hero-secondary:hover {
        background-color: #f8f9fa;
    }
    .presentation-box { background-color: var(--beige-creme); padding: 60px 0; border-bottom: 1px solid rgba(0,0,0,0.05); }

    .service-card {
        background-color: #F8F1E7 !important;
        border: none !important;
        border-radius: 16px !important;
        padding: 40px 30px;
        transition: transform 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-5px);
    }
    .service-icon {
        color: #6B8E23;
        font-size: 2.5rem;
    }

    :root {
        --vert-sauge: #788475;
        --beige-creme: #fdfaf6;
        --marron-doux: #2c1d11;
        --orange-brand: #e06a3b;
    }
    .font-serif { font-family: 'Playfair Display', serif; }
    .section-title { color: var(--marron-doux); font-weight: 700; margin-bottom: 40px; }
    .menu-card { border: none; border-radius: 16px; overflow: hidden; background: #fff; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .menu-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
    .badge-regime { background-color: var(--vert-sauge); color: white; border-radius: 20px; padding: 5px 15px; font-size: 0.85rem; }
    .badge-theme { background-color: var(--orange-brand); color: white; border-radius: 20px; padding: 5px 15px; font-size: 0.85rem; }
    .btn-sauge { background-color: var(--vert-sauge); color: white; border-radius: 30px; padding: 10px 25px; transition: all 0.3s; border: none; }
    .btn-sauge:hover { background-color: var(--marron-doux); color: white; }
    .review-box { background-color: var(--beige-creme); padding: 80px 0; }
    .review-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid rgba(0,0,0,0.03); }
    .stars { color: #ffc107; }
</style>

<!-- Grand titre d'accueil et carrousel principal de présentation -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="hero-title mb-4">Des plats frais, gourmands et adaptés à vos envies</h1>
                <p class="fs-5 text-muted mb-5">
                    Découvrez nos menus préparés avec soin, disponibles en livraison pour vos événements, repas du quotidien et besoins alimentaires spécifiques.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-hero-primary fs-6 shadow-sm"><i class="bi bi-card-list me-2"></i>Découvrir nos menus</a>
                    <a href="#" class="btn btn-hero-secondary fs-6 shadow-sm">Voir nos formules</a>
                </div>
            </div>
            
            <!-- images CARROUSEL TRAITEUR -->
            <div class="col-lg-6">
                <div id="heroTraiteurCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <!-- Photo 1 : Buffet / Événement -->
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=800" 
                                 class="d-block w-100" 
                                 style="height: 420px; object-fit: cover;" 
                                 alt="Buffet traiteur événementiel">
                        </div>
                        <!-- Photo 2 : Cocktail / Plateaux -->
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?auto=format&fit=crop&q=80&w=800" 
                                 class="d-block w-100" 
                                 style="height: 420px; object-fit: cover;" 
                                 alt="Cocktail et pièces salées">
                        </div>
                        <!-- Photo 3 : Mets raffinés / Dressage -->
                        <div class="carousel-item">
                            <img src="https://images.pexels.com/photos/26690289/pexels-photo-26690289.jpeg" 
                                 class="d-block w-100" 
                                 style="height: 420px; object-fit: cover;" 
                                 alt="Plats cuisinés et dressés avec soin">
                        </div>
                    </div>
                    
                    <!-- Indicateurs (petits points de défilement) -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#heroTraiteurCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#heroTraiteurCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#heroTraiteurCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Les 3 petits blocs d'avantages (livraison, sur-mesure, expérience) -->
<section class="py-5 mb-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card h-100 text-center shadow-sm">
                    <div class="mb-3 service-icon">
                        <i class="bi bi-clock-history"></i> </div>
                    <h3 class="h4 fw-bold mb-2">Livraison rapide</h3>
                    <p class="text-muted mb-0">"Vos repas livrés frais à l'heure"</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card service-card h-100 text-center shadow-sm">
                    <div class="mb-3 service-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-2">Adapté à vos besoins</h3>
                    <p class="text-muted mb-0">"Des menus variés selon vos préférences"</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card service-card h-100 text-center shadow-sm">
                    <div class="mb-3 service-icon">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-2">Une expertise reconnue</h3>
                    <p class="text-muted mb-0">"25 ans de savoir-faire culinaire"</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Présentation de l'entreprise -->
<section class="presentation-box">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <h2 class="display-5 fw-bold mb-4" style="color: var(--vert-sauge); font-family: 'Playfair Display', serif;">Notre Histoire</h2>
                <p class="lead">Depuis plus de 25 ans, Vite & Gourmand accompagne vos événements à Bordeaux avec une cuisine traiteur authentique et raffinée.</p>
                <p>Fondée par <strong>Julie et José</strong>, l’entreprise s’appuie sur une passion commune : proposer des menus gourmands, adaptés à chaque occasion et renouvelés au fil des saisons.</p>
                <p class="text-muted">Grâce à notre nouvelle application web, nous modernisons notre service afin de rendre nos menus accessibles à tous et simplifier la prise de commande.</p>
            </div>
            <div class="col-lg-5">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&q=80&w=600" class="img-fluid rounded-4 shadow" alt="Cuisine Vite et Gourmand">
            </div>
        </div>
    </div>
</section>

<!-- Liste des 3 cartes de menus -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 font-serif section-title">Découvrez nos Formules Traiteur</h2>
            <p class="text-muted">Une alliance parfaite entre rapidité de service et excellence gastronomique.</p>
        </div>

        <div class="row g-4">
            <!-- Carte 1 : Menu Terroir -->
            <div class="col-md-4">
                <div class="card menu-card shadow-sm h-100">
                    <div id="carouselMenu1" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.pexels.com/photos/38225382/pexels-photo-38225382.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Classique 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.pexels.com/photos/25916398/pexels-photo-25916398.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Classique 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu1" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-regime">Classique</span>
                                <span class="badge-theme">Événement</span>
                            </div>
                            <h3 class="h4 font-serif text-dark mb-2">Menu Terroir & Tradition</h3>
                            <p class="text-muted small mb-3">Une sélection rigoureuse de produits du Sud-Ouest pour sublimer vos grandes tablées de fêtes.</p>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Min : <strong>10 pers.</strong></span>
                                <span class="h5 mb-0" style="color: var(--marron-doux);"><strong>45.00 € / pers.</strong></span>
                            </div>
                            <a href="/menus/1" class="btn btn-sauge w-100">Je découvre</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 2 : Menu Végétarien -->
            <div class="col-md-4">
                <div class="card menu-card shadow-sm h-100">
                    <div id="carouselMenu2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.pexels.com/photos/39388384/pexels-photo-39388384.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Végétarien 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.pexels.com/photos/18478461/pexels-photo-18478461.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Végétarien 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu2" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-regime">Végétarien</span>
                                <span class="badge-theme">Classique</span>
                            </div>
                            <h3 class="h4 font-serif text-dark mb-2">Menu Jardin des Délices</h3>
                            <p class="text-muted small mb-3">Des mariages subtils de légumes anciens locaux, herbes fraîches et céréales croquantes.</p>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Min : <strong>6 pers.</strong></span>
                                <span class="h5 mb-0" style="color: var(--marron-doux);"><strong>38.00 € / pers.</strong></span>
                            </div>
                            <a href="/menus/2" class="btn btn-sauge w-100">Je découvre</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 3 : Menu Vegan -->
            <div class="col-md-4">
                <div class="card menu-card shadow-sm h-100">
                    <div id="carouselMenu3" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.pexels.com/photos/36318388/pexels-photo-36318388.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Vegan 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.pexels.com/photos/17676350/pexels-photo-17676350.jpeg" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Plat Vegan 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu3" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu3" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                    
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-regime">Vegan</span>
                                <span class="badge-theme">Saisonnier</span>
                            </div>
                            <h3 class="h4 font-serif text-dark mb-2">Menu Douceur Éco-Responsable</h3>
                            <p class="text-muted small mb-3">Une gastronomie 100% végétale créative, respectueuse de notre planète et pleine de vitalité.</p>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Min : <strong>8 pers.</strong></span>
                                <span class="h5 mb-0" style="color: var(--marron-doux);"><strong>42.00 € / pers.</strong></span>
                            </div>
                            <a href="/menus/3" class="btn btn-sauge w-100">Je découvre</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blocs d'engagements (produits locaux, sécurité) -->
<section class="py-5" style="border-top: 1px solid rgba(0,0,0,0.05);">
    <div class="container">
        <div class="row align-items-center g-5 flex-row-reverse">
            <div class="col-lg-6">
                <h2 class="display-6 font-serif section-title">Notre Engagement Professionnel</h2>
                <p>Pour assurer la réussite de votre événement, l'équipe logistique et cuisine de Julie & José garantit :</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-check-circle-fill me-2" style="color: var(--vert-sauge);"></i> <strong>Sourcing 100% Local :</strong> Ingrédients en circuits courts issus directement de la région bordelaise.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill me-2" style="color: var(--vert-sauge);"></i> <strong>Sécurité Sanitaire et Allergènes :</strong> Maîtrise totale de la traçabilité de chaque plat.</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill me-2" style="color: var(--vert-sauge);"></i> <strong>Respect des Délais :</strong> Livraison chaude ou réfrigérée sécurisée sur Bordeaux et environs.</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&q=80&w=600" class="img-fluid rounded-4 shadow-sm" alt="Professionnalisme Équipe">
            </div>
        </div>
    </div>
</section>

<!-- Avis des clients -->
<section class="review-box">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 font-serif section-title">Ce que disent nos Clients</h2>
            <p class="text-muted">Avis authentiques vérifiés par nos équipes après dégustation.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="review-card shadow-sm h-100">
                    <div class="stars mb-2">★★★★★</div>
                    <p class="card-text">"Un anniversaire mémorable grâce au Menu Terroir. La logistique était parfaite et les plats raffinés !"</p>
                    <h5 class="h6 font-serif mb-0 mt-3">— Pierre D., Talence</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="review-card shadow-sm h-100">
                    <div class="stars mb-2">★★★★★</div>
                    <p class="card-text">"Le menu Jardin des Délices a bluffé tous mes convives, même non végétariens. Un grand bravo à José !"</p>
                    <h5 class="h6 font-serif mb-0 mt-3">— Marine L., Bordeaux Centre</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="review-card shadow-sm h-100">
                    <div class="stars mb-2">★★★★☆</div>
                    <p class="card-text">"Commande simple sur le site, ponctualité exemplaire et fraîcheur absolue des produits. Je recommande chaudement."</p>
                    <h5 class="h6 font-serif mb-0 mt-3">— Thomas M., Mérignac</h5>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection