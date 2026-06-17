<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vite & Gourmand - Traiteur Premium')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <style>
        /* Intégration de ta nouvelle palette de couleurs et typographies */
        :root {
            --vert-sauge: #6B8E23;
            --beige-creme: #F8F1E7;
            --terracotta: #D96C4A;
            --anthracite: #252525;
            --blanc-casse: #FFFDF8;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--anthracite);
            background-color: var(--blanc-casse);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, .brand-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        main {
            flex: 1;
        }

        /* Style du Header demandé */
        .navbar {
            background-color: var(--blanc-casse) !important;
            border-bottom: 1px solid rgba(37, 37, 37, 0.1);
        }

        .navbar-brand {
            color: var(--vert-sauge) !important;
            font-size: 1.4rem;
        }

        .nav-link {
            color: var(--anthracite) !important;
            font-weight: 500;
            margin-0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--vert-sauge) !important;
        }

        /* Style des boutons Terracotta */
        .btn-connexion {
            color: var(--terracotta) !important;
            border: 2px solid var(--terracotta);
            background: transparent;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-connexion:hover {
            background-color: var(--terracotta);
            color: white !important;
        }

        .btn-inscrire {
            background-color: var(--terracotta);
            color: white !important;
            font-weight: 600;
            border-radius: 6px;
            border: 2px solid var(--terracotta);
            transition: all 0.3s ease;
        }

        .btn-inscrire:hover {
            background-color: #c55a39;
            border-color: #c55a39;
        }

        /* Pied de page */
        footer {
            background-color: var(--anthracite);
            color: var(--blanc-casse);
        }
    </style>
</head>
<body>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->has('account'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first('account') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand brand-title" href="{{ url('/') }}">
                <i class="bi bi-recipe-by-media me-2"></i>Vite & Gourmand
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/menus') }}">Menus</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/evenements') }}">Événements</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                </ul>
                <div class="d-flex gap-3">
                    <a href="{{ url('/connexion') }}" class="btn btn-outline-dark me-2">Connexion</a>
                    <a href="{{ url('/inscription') }}" class="btn btn-dark">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

   <footer class="py-5 text-start" style="background-color: #2B1E16; color: #FFFDF8; font-family: 'Montserrat', sans-serif;">
        <div class="container">
            <div class="row g-4">
                
             <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <a class="brand-title fs-4 fw-bold text-decoration-none" href="{{ url('/') }}" style="color: var(--vert-sauge);">
                            <i class="bi bi-recipe-by-media me-2"></i>Vite & Gourmand
                        </a>
                    </div>
                    <p class="small mb-4" style="color: #D3C2B5; line-height: 1.6;">
                        Découvrez l'alliance parfaite de la rapidité et de la qualité gastronomique. Des ingrédients frais, des saveurs audacieuses, prêts en quelques minutes.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="footer-social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-social-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="footer-social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold fs-5 mb-3" style="font-family: 'Playfair Display', serif; color: #FFFDF8;">Liens Rapides</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 m-0 p-0">
                        <li><a href="{{ url('/') }}" class="custom-footer-link">Accueil</a></li>
                        <li><a href="{{ url('/menus') }}" class="custom-footer-link">Menus</a></li>
                        <li><a href="{{ url('/evenements') }}" class="custom-footer-link">Événements</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-white text-decoration-none opacity-75">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold fs-5 mb-3" style="font-family: 'Playfair Display', serif; color: #FFFDF8;">Horaires</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 m-0 p-0 small" style="color: #D3C2B5;">
                        <li class="d-flex justify-content-between border-bottom border-secondary pb-1"><span>Lundi - Vendredi :</span> <span class="text-white fw-medium">11h00 - 22h00</span></li>
                        <li class="d-flex justify-content-between border-bottom border-secondary pb-1"><span>Samedi :</span> <span class="text-white fw-medium">11h00 - 23h00</span></li>
                        <li class="d-flex justify-content-between pb-1"><span>Dimanche :</span> <span class="text-white fw-medium">11h30 - 22h00</span></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold fs-5 mb-3" style="font-family: 'Playfair Display', serif; color: #FFFDF8;">Mentions Légales</h5>
                  <ul class="list-unstyled">
                    <li><a href="{{ url('/mentions-legales') }}" class="text-white text-decoration-none opacity-75">Mentions Légales</a></li>
                    <li><a href="{{ url('/cgv') }}" class="text-white text-decoration-none opacity-75">Conditions Générales de Vente (CGV)</a></li>
                    <li><a href="{{ url('/politique-confidentialite') }}" class="text-white text-decoration-none opacity-75">Politique de Confidentialité</a></li>
                </ul>
                </div>

            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 pt-4" style="border-top: 1px solid rgba(255, 253, 248, 0.1); color: #A69285; font-size: 0.85rem;">
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} Vite & Gourmand. Tous droits réservés.</p>
                <p class="mb-0">Créé avec <i class="bi bi-heart-fill text-danger mx-1"></i> pour les passionnés de cuisine.</p>
            </div>
        </div>
    </footer>

    <style>
        /* Style des liens textuels du footer */
        .custom-footer-link {
            color: #D3C2B5 !important; /* Couleur sable/crème de ton image */
            text-decoration: none !important;
            font-size: 0.95rem;
            transition: color 0.2s ease-in-out;
            display: inline-block;
        }
        .custom-footer-link:hover {
            color: #FFFDF8 !important; /* Devient blanc pur au survol */
        }

        /* Style des boutons de réseaux sociaux carrés de ton image */
        .footer-social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: rgba(255, 253, 248, 0.05) !important;
            color: #D3C2B5 !important;
            border-radius: 6px;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }
        .footer-social-btn:hover {
            background-color: rgba(255, 253, 248, 0.15) !important;
            color: #FFFDF8 !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>