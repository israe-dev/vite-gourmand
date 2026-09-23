@extends('layouts.main-site')

@section('title', 'Détail de la commande — Vite & Gourmand')

@section('content')
<!-- Conteneur principal de la page de détail -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- En-tête : Titre de la commande et bouton retour -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 fw-bold text-dark mb-1">Commande #{{ $commande->id }}</h1>
                            <p class="text-muted mb-0">Suivi de votre prestation</p>
                        </div>
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>

                    <!-- Gestion des erreurs de validation -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Message de succès -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- informations de la commande -->
                    <div class="row g-3">
                        <!-- Menu choisi -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Menu</label>
                            <div class="form-control bg-light">{{ $commande->menu?->titre ?? 'Menu non renseigné' }}</div>
                        </div>

                        <!-- Statut actuel de la commande -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Statut</label>
                            <div class="form-control bg-light">{{ ucfirst($commande->statut) }}</div>
                        </div>

                        <!-- Date de la prestation -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Date prestation</label>
                            <div class="form-control bg-light">{{ \Carbon\Carbon::parse($commande->date_prestation)->format('d/m/Y') }}</div>
                        </div>

                        <!-- Heure de livraison -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Heure livraison</label>
                            <div class="form-control bg-light">{{ \Carbon\Carbon::parse($commande->heure_livraison)->format('H:i') }}</div>
                        </div>

                        <!-- Lieu de livraison -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Lieu de livraison</label>
                            <div class="form-control bg-light">{{ $commande->lieu_livraison }}</div>
                        </div>

                        <!-- Nombre de personnes -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nombre de personnes</label>
                            <div class="form-control bg-light">{{ $commande->nombre_personnes }} pers.</div>
                        </div>

                        <!-- Prix du menu -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Prix menu</label>
                            <div class="form-control bg-light">{{ number_format($commande->prix_menu, 2, ',', ' ') }} €</div>
                        </div>

                        <!-- Frais de livraison -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Prix livraison</label>
                            <div class="form-control bg-light">{{ number_format($commande->prix_livraison, 2, ',', ' ') }} €</div>
                        </div>
                    </div>

                    <!-- Encadré du montant total -->
                    <div class="card border-0 bg-light mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total</span>
                                <strong class="fs-5 text-primary">
                                    {{ number_format($commande->prix_menu + $commande->prix_livraison, 2, ',', ' ') }} €
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Bloc de suivi de commande/historique -->
                    @php
                        $hasSuivis = method_exists($commande, 'suivis') && $commande->suivis()->exists();
                    @endphp
                    @if($commande->statut !== 'en attente' && $hasSuivis)
                        <div class="card border-0 bg-light mt-4 p-4 shadow-sm">
                            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-tasks text-primary me-2"></i> Suivi de la commande</h5>
                            <ul class="timeline list-unstyled mb-0">
                                @foreach($commande->suivis as $suivi)
                                    <li class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <div>
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 me-2">{{ ucfirst($suivi->statut) }}</span>
                                            <span class="text-muted small">{{ $suivi->description ?? '' }}</span>
                                        </div>
                                        <span class="text-muted fs-7">
                                            {{ \Carbon\Carbon::parse($suivi->created_at)->format('d/m/Y à H:i') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Actions disponibles si la commande est en attente -->
                    @if($commande->statut === 'en attente')
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('customer.orders.edit', $commande->id) }}" class="btn btn-primary">
                                Modifier la commande
                            </a>
                            <form action="{{ route('customer.orders.cancel', $commande->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Voulez-vous vraiment annuler cette commande ?');">
                                    Annuler la commande
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Formulaire d'avis client si la commande est terminée -->
                    @if($commande->statut === 'terminée' && !$commande->avis()->exists())
                        <div class="mt-5 border-top pt-4">
                            <h5 class="fw-bold mb-3">Laisser un avis</h5>
                            <form action="{{ route('customer.reviews.store', $commande->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note</label>
                                    <select name="note" id="note" class="form-select" required>
                                        <option value="">Choisir une note</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}/5</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Commentaire</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" placeholder="Racontez votre expérience..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Publier l'avis</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection