@extends('layouts.admin')

@section('title', 'Gestion des Allergènes & Régimes - Admin')

@section('content')
<div class="container-fluid">
    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Titre de la page d'extension -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-dark fw-bold mb-0">Configurations des Plats : Allergènes & Régimes</h2>
    </div>

    <div class="row g-4">
        
        <!-- BLOC 1 : ALLERGÈNES -->
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Ajouter un Allergène</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.allergenes.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" placeholder="Ex: Gluten, Lactose, Crustacés..." required>
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>
                        @error('libelle')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- Liste des allergènes -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3" style="width: 80px;">ID</th>
                                    <th class="py-3">Nom de l'allergène</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allergenes as $allergene)
                                    <tr>
                                        <td class="px-4 fw-bold text-muted">#{{ $allergene->id }}</td>
                                        <td class="fw-semibold text-dark">{{ $allergene->libelle }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">Aucun allergène enregistré pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOC 2 : RÉGIMES ALIMENTAIRES -->
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-seedling me-2 text-success"></i> Ajouter un Régime Alimentaire</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.regimes.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" placeholder="Ex: Végétarien, Végan, Sans Porc..." required>
                            <button class="btn btn-success px-4" type="submit">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>
                        @error('libelle')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

            <!-- Liste des régimes -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3" style="width: 80px;">ID</th>
                                    <th class="py-3">Nom du régime</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regimes as $regime)
                                    <tr>
                                        <td class="px-4 fw-bold text-muted">#{{ $regime->id }}</td>
                                        <td class="fw-semibold text-dark">{{ $regime->libelle }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">Aucun régime enregistré pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection