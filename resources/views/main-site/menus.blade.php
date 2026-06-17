@extends('layouts.main-site')

@section('title', 'Nos Menus | Vite & Gourmand')

@section('content')
<style>
    .menu-card { border: none; border-radius: 15px; overflow: hidden; background: white; transition: transform 0.3s ease; }
    .menu-card:hover { transform: translateY(-5px); }
    .card-carousel { height: 250px; }
    .card-carousel img { height: 250px; width: 100%; object-fit: cover; }
    .badge-custom { position: absolute; top: 15px; left: 15px; z-index: 10; background: var(--vert-sauge); color: white; padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; }
    .btn-details { background-color: var(--terracotta); color: white; border: none; font-weight: 600; padding: 10px 0; border-radius: 6px; width: 100%; transition: 0.3s; }
    .btn-details:hover { background-color: #c55a39; color: white; }
</style>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold" style="font-family: 'Playfair Display', serif;">Découvrez notre Carte</h2>
            <p class="text-muted">Explorez nos créations culinaires et défilez les images pour chaque menu.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card menu-card shadow-sm position-relative">
                    <span class="badge-custom">Végétarien</span>
                    <div id="carouselMenu1" class="carousel slide card-carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500" alt="Plat 1"></div>
                            <div class="carousel-item"><img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=500" alt="Plat 2"></div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu1" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu1" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">Le Jardin d'Été</h4>
                        <p class="small text-muted mb-3">Thème : Fraîcheur | 24.90€</p>
                        <button class="btn-details">Voir les détails</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card menu-card shadow-sm position-relative">
                    <span class="badge-custom" style="background: var(--anthracite);">Classique</span>
                    <div id="carouselMenu2" class="carousel slide card-carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img src="https://images.unsplash.com/photo-1555244162-803834f70033?w=500" alt="Viande"></div>
                            <div class="carousel-item"><img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=500" alt="Grillade"></div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu2" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu2" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">L'Éclat Bordelais</h4>
                        <p class="small text-muted mb-3">Thème : Tradition | 32.00€</p>
                        <button class="btn-details">Voir les détails</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card menu-card shadow-sm position-relative">
                    <span class="badge-custom" style="background: var(--terracotta);">Végan</span>
                    <div id="carouselMenu3" class="carousel slide card-carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active"><img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500" alt="Salade"></div>
                            <div class="carousel-item"><img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=500" alt="Légumes"></div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMenu3" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMenu3" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">Douceur Veggie</h4>
                        <p class="small text-muted mb-3">Thème : Nature | 19.50€</p>
                        <button class="btn-details">Voir les détails</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection