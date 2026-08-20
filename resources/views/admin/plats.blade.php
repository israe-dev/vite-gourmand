@extends('layouts.admin')

@section('title', 'Gestion des Plats - Admin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-dark fw-bold mb-0">Gestion du Catalogue des Plats & Stocks</h2>
    </div>

    <div class="row g-4">
        <!-- FORMULAIRE DE CRÉATION AVEC UPLOAD D'IMAGE -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-plus-circle me-2 text-primary"></i> Ajouter un nouveau Plat</h5>
                </div>
                <div class="card-body">
                    <!-- ENCTYPE RAJOUTÉ POUR COMPRENDRE LES FICHIERS -->
                    <form action="{{ route('admin.plats.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nom du Plat -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Nom du plat</label>
                            <input type="text" name="nom" class="form-control" placeholder="Ex: Tataki de Thon Rouge" required>
                        </div>

                        <!-- Type de Plat (Catégorie) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Type de service</label>
                            <select name="type" class="form-select" required>
                                <option value="" disabled selected>Choisir un type...</option>
                                <option value="entree">🥗 Entrée</option>
                                <option value="plat">🍽️ Plat Principal</option>
                                <option value="dessert">🍰 Dessert</option>
                            </select>
                        </div>

                        <!-- Quantité / Gestion de Stock Physique -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Quantité disponible (Stock initial)</label>
                            <input type="number" name="quantite" class="form-control" min="0" placeholder="Ex: 50" required>
                        </div>

                        <!-- AJOUT : Champ Photo du plat -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Photo du plat</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>

                        <!-- Description détaillée du Plat -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Description & Composition</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Description du plat pour les clients ou la modale..."></textarea>
                        </div>

                        <!-- Sélection des Allergènes (Menu Tags) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted d-block mb-2">Allergènes associés</label>
                            <div class="border rounded p-3 bg-light" style="max-height: 140px; overflow-y: auto;">
                                @forelse($allergenes as $allergene)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="allergenes[]" value="{{ $allergene->id }}" id="allergene_{{ $allergene->id }}">
                                        <label class="form-check-label text-dark" for="allergene_{{ $allergene->id }}">
                                            {{ $allergene->libelle }}
                                        </label>
                                    </div>
                                @empty
                                    <span class="text-muted small">Aucun tag créé. Va dans l'onglet Menu Tags.</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <button class="btn btn-primary w-100 py-2 fw-bold" type="submit">
                            <i class="fas fa-cookie-bite me-2"></i> Enregistrer en Cuisine
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLEAU D'AFFICHAGE ET DE GESTION PAR ONGLET -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom p-2">
                    <ul class="nav nav-pills card-header-pills" id="platTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="entrees-tab" data-bs-toggle="tab" data-bs-target="#entrees" type="button" role="tab">🥗 Entrées</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="plats-tab" data-bs-toggle="tab" data-bs-target="#platsPrincipauxTab" type="button" role="tab">🍽️ Plats Principaux</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="desserts-tab" data-bs-toggle="tab" data-bs-target="#desserts" type="button" role="tab">🍰 Desserts</button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="platTabsContent">
                        <div class="tab-pane fade show active" id="entrees" role="tabpanel">
                            @include('partials.table-plats', ['listePlats' => $entrees])
                        </div>
                        <div class="tab-pane fade" id="platsPrincipauxTab" role="tabpanel">
                            @include('partials.table-plats', ['listePlats' => $platsPrincipaux])
                        </div>
                        <div class="tab-pane fade" id="desserts" role="tabpanel">
                            @include('partials.table-plats', ['listePlats' => $desserts])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALE BOOTSTRAP ADAPTÉE POUR LES IMAGES DYNAMIQUES -->
<div class="modal fade" id="detailPlatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark" id="modalPlatNom">Détails du Plat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Zone d'affichage dynamique de la photo -->
                <div class="text-center mb-3">
                    <div id="modalPlatImageContainer">
                        <!-- Rempli en JS -->
                    </div>
                </div>
                <h6 class="fw-bold text-secondary">Description / Composition :</h6>
                <p id="modalPlatDescription" class="text-muted text-break">Aucune description fournie.</p>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="small text-muted d-block">Stock Physique :</span>
                        <span id="modalPlatStock" class="badge bg-dark fs-6">0</span>
                    </div>
                    <div>
                        <span class="small text-muted d-block">Catégorie :</span>
                        <span id="modalPlatCategorie" class="badge bg-primary text-uppercase">Plat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailModal = document.getElementById('detailPlatModal');
    if (detailModal) {
        detailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            const nom = button.getAttribute('data-nom');
            const description = button.getAttribute('data-description') || 'Aucune description rédigée.';
            const stock = button.getAttribute('data-stock');
            const type = button.getAttribute('data-type');
            const photo = button.getAttribute('data-photo');

            document.getElementById('modalPlatNom').textContent = nom;
            document.getElementById('modalPlatDescription').textContent = description;
            document.getElementById('modalPlatStock').textContent = stock;
            document.getElementById('modalPlatCategorie').textContent = type;

            // Gestion dynamique de l'affichage de l'image
            const imgContainer = document.getElementById('modalPlatImageContainer');
            if (photo) {
                imgContainer.innerHTML = `<img src="/storage/${photo}" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;" alt="${nom}">`;
            } else {
                imgContainer.innerHTML = `<div class="p-4 bg-light rounded text-muted mb-2"><i class="fas fa-image fa-3x"></i><br><span class="small">Aucune illustration</span></div>`;
            }
        });
    }
});
</script>
@endsection