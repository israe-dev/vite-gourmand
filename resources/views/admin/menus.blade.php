@extends('layouts.admin')

@section('title', 'Gestion des Menus - Admin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-dark fw-bold mb-0">Gestion du Catalogue des Menus</h2>
        <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#createMenuModal">
            <i class="fas fa-plus me-2"></i> Créer un nouveau menu
        </button>
    </div>

    <div class="mb-3">
        <h5 class="text-secondary fw-semibold mb-3">
            <i class="fas fa-folder-open me-2"></i> Liste des menus au catalogue ({{ $menus->count() }})
        </h5>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="px-4 py-3" style="width: 100px;">Visuel</th>
                    <th class="py-3">Détails du Menu</th>
                    <th class="py-3">Thème & Régime</th>
                    <th class="py-3" style="width: 180px;">Tarification</th>
                    <th class="py-3" style="width: 130px;">Statut Public</th>
                    <th class="py-3 text-end px-4" style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td class="px-4">
                            @if($menu->photo)
                                <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->titre }}" class="img-thumbnail rounded" style="width: 70px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded text-center border d-flex align-items-center justify-content-center text-muted" style="width: 70px; height: 50px; font-size: 11px;">
                                    📸 N/A
                                </div>
                            @endif
                        </td>

                        <td>
                            <div class="fw-bold text-dark fs-6 mb-0">{{ $menu->titre }}</div>
                            @if($menu->description)
                                <small class="text-muted text-truncate d-block mb-1" style="max-width: 300px;">{{ $menu->description }}</small>
                            @endif
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @forelse($menu->plats as $plat)
                                    <span class="badge bg-light text-dark border px-2 py-0.5 small fw-normal" title="Allergènes : {{ $plat->allergenes->pluck('libelle')->join(', ') ?: 'Aucun' }}">
                                        🍳 {{ $plat->nom }}
                                    </span>
                                @empty
                                    <span class="text-danger small italic">Aucun plat lié</span>
                                @endforelse
                            </div>
                        </td>

                        <td>
                            <div class="mb-1">
                                @if($menu->theme)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fw-bold rounded-pill text-uppercase tracking-wider small">
                                        🎉 {{ $menu->theme->libelle }}
                                    </span>
                                @else
                                    <span class="text-muted small italic">Aucun thème</span>
                                @endif
                            </div>
                            <div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-bold rounded-pill small">
                                    {{ $menu->regime === 'classique' ? '🍖 ' : '🌱 ' }}{{ ucfirst($menu->regime) }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="fw-bold text-dark mb-0">{{ number_format($menu->prix_par_personne, 2) }} € <span class="text-muted fw-normal small">/ pers.</span></div>
                            <div class="text-secondary small mb-1">Total Min: <strong>{{ number_format($menu->prix_par_personne * $menu->nb_personne_minimum, 2) }} €</strong> ({{ $menu->nb_personne_minimum }}p.)</div>
                            <div>
                                @if($menu->quantite_restante == 0)
                                    <span class="badge bg-danger-subtle text-danger px-2 py-0.5 rounded small">Rupture</span>
                                @else
                                    <span class="badge bg-light text-secondary border px-2 py-0.5 rounded small">Stock : {{ $menu->quantite_restante }}</span>
                                @endif
                            </div>
                        </td>

                        <td>
                            @if($menu->is_visible ?? true)
                                <span class="badge bg-success text-white px-2.5 py-1.5 rounded-pill shadow-sm small">
                                    <i class="fas fa-eye me-1"></i> En ligne
                                </span>
                            @else
                                <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill shadow-sm small">
                                    <i class="fas fa-eye-slash me-1"></i> Masqué
                                </span>
                            @endif
                        </td>

                        <td class="text-end px-4">
                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive de ce menu ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-utensils fa-2x mb-3 d-block text-secondary opacity-50"></i>
                            Aucun menu n'est enregistré dans le catalogue.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-utensils text-primary me-2"></i> Composer un nouveau menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Titre du Menu</label>
                            <input type="text" name="titre" class="form-control" required placeholder="Ex: Prestige de Noël">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Régime (Filtre)</label>
                            <select name="regime" class="form-select" required>
                                <option value="classique">Classique</option>
                                <option value="vegetarien">Végétarien</option>
                                <option value="vegan">Vegan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Thème (Filtre)</label>
                            <select name="theme_id" class="form-select">
                                <option value="">Aucun thème lié</option>
                                @foreach($themes as $theme)
                                    <option value="{{ $theme->id }}">{{ $theme->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Prix par personne</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="prix_par_personne" class="form-control" required placeholder="25.00">
                                <span class="input-group-text">€ / pers.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nb. personnes min.</label>
                            <input type="number" name="nb_personne_minimum" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Commandes dispos (Stock)</label>
                            <input type="number" name="quantite_restante" class="form-control" value="10" min="0" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Photo représentative du Menu</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_visible" value="1" id="visibilitySwitch" checked>
                                <label class="form-check-label fw-semibold text-primary" for="visibilitySwitch">Publier immédiatement</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Présentation alléchante du menu..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Conditions spécifiques d'organisation</label>
                            <textarea name="conditions" class="form-control" rows="2" placeholder="Ex: Commander minimum 7 jours à l'avance. À conserver au frais."></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold text-primary d-block mb-2"><i class="fas fa-layer-group me-1"></i> Composer la liste des plats inclus :</label>
                            <div class="border rounded p-3 bg-light" style="max-height: 180px; overflow-y: auto;">
                                @foreach($plats as $plat)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="plats[]" value="{{ $plat->id }}" id="plat-{{ $plat->id }}">
                                        <label class="form-check-label text-dark" for="plat-{{ $plat->id }}">
                                            <span class="badge bg-secondary-subtle text-secondary me-1 small">{{ ucfirst($plat->type) }}</span> 
                                            <strong>{{ $plat->nom }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-save me-2"></i> Enregistrer le Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection