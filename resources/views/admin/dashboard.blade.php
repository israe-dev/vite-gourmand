@extends('layouts.admin')

@section('title', 'Dashboard Admin — Vite & Gourmand')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card text-white h-100 shadow-sm border-0 position-relative" style="background-color: #3b76f6; border-radius: 4px;">
            <div class="card-body p-3 pb-5">
                <h2 class="fw-bold mb-1">0</h2>
                <div class="small opacity-75">Pending Orders</div>
                <i class="fas fa-question-circle opacity-25 position-absolute" style="right: 20px; top: 25px; font-size: 2.5rem;"></i>
            </div>
            <div class="text-center py-2 border-top border-white-50 bg-black-50" style="background: rgba(0,0,0,0.08); border-radius: 0 0 4px 4px;">
                <a href="#" class="text-white text-decoration-none small d-block">View <i class="fas fa-arrow-circle-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="card text-white h-100 shadow-sm border-0 position-relative" style="background-color: #2ecc71; border-radius: 4px;">
            <div class="card-body p-3 pb-5">
                <h2 class="fw-bold mb-1">0</h2>
                <div class="small opacity-75">Online Orders</div>
                <i class="fas fa-globe opacity-25 position-absolute" style="right: 20px; top: 25px; font-size: 2.5rem;"></i>
            </div>
            <div class="text-center py-2 border-top border-white-50" style="background: rgba(0,0,0,0.08); border-radius: 0 0 4px 4px;">
                <a href="#" class="text-white text-decoration-none small d-block">View <i class="fas fa-arrow-circle-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="card text-white h-100 shadow-sm border-0 position-relative" style="background-color: #ff9f43; border-radius: 4px;">
            <div class="card-body p-3 pb-5">
                <h2 class="fw-bold mb-1">0</h2>
                <div class="small opacity-75">Instore Orders</div>
                <i class="fas fa-shopping-bag opacity-25 position-absolute" style="right: 20px; top: 25px; font-size: 2.5rem;"></i>
            </div>
            <div class="text-center py-2 border-top border-white-50" style="background: rgba(0,0,0,0.08); border-radius: 0 0 4px 4px;">
                <a href="#" class="text-white text-decoration-none small d-block">View <i class="fas fa-arrow-circle-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="card text-white h-100 shadow-sm border-0 position-relative" style="background-color: #ff4757; border-radius: 4px;">
            <div class="card-body p-3 pb-5">
                <h2 class="fw-bold mb-1">0</h2>
                <div class="small opacity-75">All Orders</div>
                <i class="fas fa-chart-pie opacity-25 position-absolute" style="right: 20px; top: 25px; font-size: 2.5rem;"></i>
            </div>
            <div class="text-center py-2 border-top border-white-50" style="background: rgba(0,0,0,0.08); border-radius: 0 0 4px 4px;">
                <a href="#" class="text-white text-decoration-none small d-block">View <i class="fas fa-arrow-circle-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 6px;">
    <div class="card-body p-4">
        <h5 class="card-title fw-bold text-dark mb-4" style="font-size: 1.1rem;">Sales Bar Chart (2026)</h5>
        <div style="position: relative; height: 340px; width: 100%;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(54, 162, 235, 0.15)',
                    borderColor: 'rgba(54, 162, 235, 0.4)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: -0.4,
                        max: 1.0,
                        ticks: { stepSize: 0.2, color: '#9aa0ac' },
                        grid: { color: '#eaedf1' }
                    },
                    x: {
                        ticks: { color: '#9aa0ac' },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush