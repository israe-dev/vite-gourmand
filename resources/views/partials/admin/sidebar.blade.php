<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin - Vite & Gourmand')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body { background-color: #f4f7f6; font-family: 'Nunito', sans-serif; }
        .navbar-top { background-color: #ffffff; height: 60px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .sidebar { background-color: #222437; min-height: 100vh; color: #a3a6b7; }
        .sidebar .nav-link { color: #a3a6b7; font-size: 0.95rem; padding: 12px 20px; display: flex; align-items: center; transition: all 0.2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #ffffff; background-color: #1a1c2d; }
        .sidebar .nav-link i { width: 25px; font-size: 1.1rem; }
        .user-panel { background-color: #1a1c2d; padding: 20px 15px; }
        .avatar-circle { width: 45px; height: 45px; background-color: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; box-shadow: 0 3px 6px rgba(0,0,0,0.16); }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0">
            
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
                <div class="user-panel d-flex align-items-center gap-3 border-bottom border-secondary mb-3">
                    <div class="avatar-circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h6 class="text-white mb-0 fw-bold">{{ Auth::user()->prenom ?? 'chrysanthus' }}</h6>
                        <small class="text-success"><i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> Admin</small>
                    </div>
                </div>
                
                <!-- LISTE DE NAVIGATION METALLIQUE FIXE SANS DEPLIANT -->
                <ul class="nav flex-column">
                    <!-- Dashboard Principal -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-desktop"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- SECTION : GÉRER LES MENUS (Affichage fixe en cascade) -->
                    <li class="nav-item mt-2">
                        <span class="nav-link text-muted fw-bold pb-1" style="font-size: 0.8rem; cursor: default; background: none !important;">
                            <i class="fas fa-utensils"></i> Gérer les Menus
                        </span>
                        <ul class="nav flex-column ms-3 ps-2 border-start border-secondary gap-1">
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ Request::routeIs('admin.menus.index') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                                    <i class="fas fa-book-open" style="font-size: 0.85rem;"></i> Menus
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ Request::routeIs('admin.plats.index') ? 'active' : '' }}" href="{{ route('admin.plats.index') }}">
                                    <i class="fas fa-cookie-bite" style="font-size: 0.85rem;"></i> Plats
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ Request::routeIs('admin.allergenes.index') ? 'active' : '' }}" href="{{ route('admin.allergenes.index') }}">
                                    <i class="fas fa-exclamation-triangle" style="font-size: 0.85rem;"></i> Allergènes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 {{ Request::routeIs('admin.themes.index') ? 'active' : '' }}" href="{{ route('admin.themes.index') }}">
                                    <i class="fas fa-tags" style="font-size: 0.85rem;"></i> Thèmes
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Grosse Catégorie : Gestion des Commandes -->
                    <li class="nav-item mt-2">
                        <a class="nav-link {{ Request::routeIs('admin.commandes.index') ? 'active' : '' }}" href="{{ route('admin.commandes.index') }}">
                            <i class="fas fa-shopping-basket"></i> Gestion des Commandes
                        </a>
                    </li>

                    <!-- Grosse Catégorie : Gestion des Avis -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('admin.avis.index') ? 'active' : '' }}" href="{{ route('admin.avis.index') }}">
                            <i class="fas fa-star"></i> Gestion des Avis
                        </a>
                    </li>

                    <!-- Gérer les Employés -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Gérer les Employés
                        </a>
                    </li>
                    
                    <!-- Liens Externes / Déconnexion -->
                    <li class="nav-item mt-4">
                        <a class="nav-link text-info" href="{{ route('home') }}">
                            <i class="fas fa-globe"></i> Main Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-9 col-lg-10 d-flex flex-column">
                
                <nav class="navbar navbar-top navbar-light px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-bars text-muted me-3 fs-5" style="cursor: pointer;"></i>
                        <span class="fw-bold text-dark fs-5">Vite & Gourmand</span>
                        <span class="badge bg-success ms-2">Espace Admin</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> ECF 2026</span>
                        <a class="text-secondary text-decoration-none small" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </nav>

                <div class="p-4 flex-grow-1">
                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>