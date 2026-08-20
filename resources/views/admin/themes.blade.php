@extends('layouts.admin')

@section('title', 'Gestion des Thèmes - Admin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-dark fw-bold mb-0">Gestion des Thèmes & Ambiances</h2>
    </div>

    <div class="row g-4">
        <!-- FORMULAIRE D'AJOUT -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-folder-plus me-2 text-primary"></i> Ajouter un Thème</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.themes.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Nom du thème / Événement</label>
                            <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" placeholder="Ex: Mariage, Buffet d'entreprise, Noël..." value="{{ old('libelle') }}" required>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary w-100 py-2 fw-bold" type="submit">
                            <i class="fas fa-save me-2"></i> Créer le thème
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLEAU D'AFFICHAGE (SANS ID) -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-secondary"><i class="fas fa-list me-2 text-success"></i> Liste des Thèmes configurés</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Nom de l'ambiance / Événement</th>
                                    <th class="py-3 text-end px-4" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($themes as $theme)
                                    <tr>
                                        <td class="px-4 fw-semibold text-dark">
                                            <i class="fas fa-bookmark text-primary opacity-50 me-2"></i>{{ $theme->libelle }}
                                        </td>
                                        <td class="text-end px-4">
                                            <form action="{{ route('admin.themes.destroy', $theme->id) }}" method="POST" onsubmit="return confirm('Supprimer ce thème ? Cela dissociera les menus associés sans les supprimer.');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-3 d-block text-secondary"></i>
                                            Aucun thème créé pour le moment.
                                        </td>
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