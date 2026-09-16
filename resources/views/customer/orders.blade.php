@extends('layouts.main-site')

@section('title', 'Mes Commandes — Vite & Gourmand')

@section('content')
<div class="container py-5">
    
    {{-- En-tête de l'espace client --}}
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Mon Espace Client</h1>
            <p class="text-muted mb-0">Ravi de vous revoir, {{ Auth::user()->nom ?? 'Gourmand' }} !</p>
        </div>
        <div>
            <a href="{{ route('order.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Passer une commande
            </a>
        </div>
    </div>

    {{-- Menu de navigation interne au dashboard client (optionnel mais pratique) --}}
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('customer.orders') }}">Mes Commandes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.account') }}">Mon Profil</a>
        </li>
    </ul>

    {{-- Affichage des messages de succès (ex: commande validée) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Contenu principal : Liste des commandes --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-receipt text-primary me-2"></i> Historique de mes prestations</h5>
        </div>
        <div class="card-body p-0">
            @if(isset($commandes) && $commandes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">N° Commande</th>
                                <th>Date prestation</th>
                                <th>Lieu</th>
                                <th>Convives</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th class="text-end px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td class="px-4"><strong>#{{ $commande->id }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($commande->date_prestation)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($commande->heure_livraison)->format('H:i') }}</td>
                                    <td>{{ $commande->lieu_livraison }}</td>
                                    <td>{{ $commande->nombre_personnes }} pers.</td>
                                    <td><strong>{{ number_format($commande->prix_menu + $commande->prix_livraison, 2) }} €</strong></td>
                                    <td>
                                        @if($commande->statut === 'validée')
                                            <span class="badge bg-success rounded-pill">Validée</span>
                                        @elseif($commande->statut === 'en attente')
                                            <span class="badge bg-warning text-dark rounded-pill">En attente</span>
                                        @elseif($commande->statut === 'annulée')
                                            <span class="badge bg-danger rounded-pill">Annulée</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">{{ ucfirst($commande->statut) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a href="{{ route('customer.order-details', $commande->id) }}" class="btn btn-sm btn-outline-secondary">
                                                Détails
                                            </a>
                                            @if($commande->statut === 'en attente')
                                                <a href="{{ route('customer.orders.edit', $commande->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('customer.orders.cancel', $commande->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Annuler cette commande ?');">
                                                        Annuler
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-5 text-center">
                    <div class="mb-3">
                        <i class="fas fa-utensils fa-3x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Aucune commande pour le moment</h5>
                    <p class="text-muted mb-4">Vous n'avez pas encore réservé de prestation traiteur avec Vite & Gourmand.</p>
                    <a href="{{ route('order.create') }}" class="btn btn-outline-primary">Découvrir nos menus</a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection