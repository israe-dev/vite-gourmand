<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3">Nom du Plat</th>
                <th class="py-3" style="width: 120px;">Stock Cuisine</th>
                <th class="py-3">Allergènes</th>
                <th class="py-3 text-end px-4" style="width: 200px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listePlats as $plat)
                <tr>
                    <td class="px-4 fw-semibold text-dark">{{ $plat->nom }}</td>
                    <td>
                        @if($plat->quantite == 0)
                            <span class="badge bg-danger rounded-pill px-2.5 py-1.5">
                                <i class="fas fa-exclamation-triangle me-1"></i> Rupture
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.5 fw-bold">
                                {{ $plat->quantite }} dispo.
                            </span>
                        @endif
                    </td>
                    <td>
                        @forelse($plat->allergenes as $allergene)
                            <span class="badge bg-light text-secondary border px-2 py-1 me-1 small">
                                <i class="fas fa-tag me-1 text-warning"></i>{{ $allergene->libelle }}
                            </span>
                        @empty
                            <span class="text-muted small">-</span>
                        @endforelse
                    </td>
                    <td class="text-end px-4">
                        <!-- BOUTON DETAILS MODALE (Avec data-photo inclus) -->
                        <button type="button" class="btn btn-outline-secondary btn-sm me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailPlatModal"
                                data-nom="{{ $plat->nom }}"
                                data-description="{{ $plat->description }}"
                                data-stock="{{ $plat->quantite }}"
                                data-type="{{ $plat->type }}"
                                data-photo="{{ $plat->photo }}">
                            <i class="fas fa-eye"></i> Voir
                        </button>

                        <!-- BOUTON SUPPRIMER SÉCURISÉ -->
                        <form action="{{ route('admin.plats.destroy', $plat->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive de ce plat du catalogue ?');" style="display:inline;">
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
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="fas fa-utensils fa-2x mb-3 d-block text-secondary"></i>
                        Aucun élément n'est enregistré dans cette catégorie.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>