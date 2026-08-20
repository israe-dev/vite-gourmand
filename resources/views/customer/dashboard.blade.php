@extends('layouts.main-site')

@section('title', 'Espace Administration — Vite & Gourmand')

@section('content')
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">Espace Administration — Vite & Gourmand</h1>
            <p class="text-muted mb-0">Bienvenue dans votre outil de gestion administrative.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card text-white p-3 shadow-sm border-0" style="background-color: #2196F3; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-0">0</h3>
                        <span class="small text-uppercase">Pending Orders</span>
                    </div>
                    <i class="fas fa-question-circle fa-2x opacity-50"></i>
                </div>
                <div class="text-center mt-3 border-top pt-2 border-white-50">
                    <small class="text-white">View <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card text-white p-3 shadow-sm border-0" style="background-color: #2ECC71; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-0">0</h3>
                        <span class="small text-uppercase">Online Orders</span>
                    </div>
                    <i class="fas fa-globe fa-2x opacity-50"></i>
                </div>
                <div class="text-center mt-3 border-top pt-2 border-white-50">
                    <small class="text-white">View <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card text-white p-3 shadow-sm border-0" style="background-color: #E67E22; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-0">0</h3>
                        <span class="small text-uppercase">Instore Orders</span>
                    </div>
                    <i class="fas fa-shopping-bag fa-2x opacity-50"></i>
                </div>
                <div class="text-center mt-3 border-top pt-2 border-white-50">
                    <small class="text-white">View <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="card text-white p-3 shadow-sm border-0" style="background-color: #E74C3C; border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-0">0</h3>
                        <span class="small text-uppercase">All Orders</span>
                    </div>
                    <i class="fas fa-chart-pie fa-2x opacity-50"></i>
                </div>
                <div class="text-center mt-3 border-top pt-2 border-white-50">
                    <small class="text-white">View <i class="fas fa-arrow-circle-right ms-1"></i></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-2"><i class="fas fa-utensils text-success me-2"></i> Gestion des Menus</h5>
                    <p class="text-muted small">Ajouter, modifier ou masquer les formules (Classique, Végétarien, Végan) directement sur l'application.</p>
                    <a href="#" class="btn btn-outline-success btn-sm mt-2">Accéder aux menus</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-2"><i class="fas fa-users text-primary me-2"></i> Gestion des Employés</h5>
                    <p class="text-muted small">Définir les comptes du personnel, attribuer les rôles et administrer l'équipe de l'établissement.</p>
                    <a href="#" class="btn btn-outline-primary btn-sm mt-2">Gérer les employés</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-muted mb-4">Sales Bar Chart (2026)</h5>
            <div style="position: relative; height:320px; width:100%">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], // Données initialisées à 0
                    backgroundColor: 'rgba(75, 73, 172, 0.2)',
                    borderColor: '#4B49AC',
                    borderWidth: 1.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        max: 1.0,
                        ticks: { stepSize: 0.2 }
                    }
                }
            }
        });
    });
</script>
@endsection