@extends('layouts.admin')

@section('title', 'Gestion des Commandes - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Gestion des Commandes</h3>
    <span class="badge bg-secondary fs-6">{{ $commandes->count() }} commande(s)</span>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Client / Menu</th>
                        <th>Prestation</th>
                        <th>Lieu</th>
                        <th>Pers.</th>
                        <th>Total</th>
                        <th>Paiement</th>
                        <th>Statut actuel</th>
                        <th class="text-end">Changer le statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                        <tr>
                            <td class="fw-bold">#{{ $commande->id }}</td>
                            <td>
                                <div><strong>Client #{{ $commande->utilisateur_id }}</strong></div>
                                <small class="text-muted">Menu #{{ $commande->menu_id }}</small>
                            </td>
                            <td>
                                <div><i class="far fa-calendar-alt me-1 text-muted"></i>{{ $commande->date_prestation }}</div>
                                @if($commande->heure_livraison)
                                    <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $commande->heure_livraison }}</small>
                                @endif
                            </td>
                            <td>
                                <small class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $commande->lieu_livraison }}">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $commande->lieu_livraison }}
                                </small>
                            </td>
                            <td>{{ $commande->nombre_personnes }}</td>
                            <td class="fw-bold text-success">{{ number_format($commande->total, 2, ',', ' ') }} €</td>
                            <td>
                                @if($commande->payment_status === 'paid' || $commande->payment_status === 'payé')
                                    <span class="badge bg-success-subtle text-success border border-success">Payé</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning">{{ ucfirst($commande->payment_status ?? 'En attente') }}</span>
                                @endif
                            </td>
                            <td>
                                @switch($commande->statut)
                                    @case('en attente')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>En attente</span>
                                        @break
                                    @case('accepté')
                                    @case('validé')
                                        <span class="badge bg-info text-dark"><i class="fas fa-check me-1"></i>Validé</span>
                                        @break
                                    @case('en préparation')
                                        <span class="badge bg-primary"><i class="fas fa-utensils me-1"></i>En préparation</span>
                                        @break
                                    @case('livré')
                                    @case('terminée')
                                        <span class="badge bg-success"><i class="fas fa-truck me-1"></i>Livré</span>
                                        @break
                                    @case('annulé')
                                    @case('refusé')
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Annulé</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($commande->statut) }}</span>
                                @endswitch
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.commandes.update-statut', $commande->id) }}" method="POST" class="d-inline-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" class="form-select form-select-sm" style="width: 140px;" onchange="this.form.submit()">
                                        <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="accepté" {{ $commande->statut == 'accepté' ? 'selected' : '' }}>Valider</option>
                                        <option value="en préparation" {{ $commande->statut == 'en préparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="livré" {{ $commande->statut == 'livré' ? 'selected' : '' }}>Livré</option>
                                        <option value="annulé" {{ $commande->statut == 'annulé' ? 'selected' : '' }}>Annuler</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Aucune commande trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection