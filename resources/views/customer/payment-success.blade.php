@extends('layouts.main-site')

@section('title', 'Paiement Réussi - Vite & Gourmand')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Carte principale élargie -->
            <div class="card shadow-sm border-0 rounded-4 p-5 text-center bg-white">
                
                <!-- Titre avec soulignement vert clair -->
                <div class="mb-4 pb-3 border-bottom border-success border-opacity-25 d-inline-block mx-auto">
                    <h1 class="h2 fw-bold mb-0" style="color: var(--anthracite);">Paiement validé avec succès</h1>
                    <div class="mx-auto mt-2 rounded" style="width: 60px; height: 3px; background-color: var(--vert-sauge);"></div>
                </div>
                
                <p class="text-muted fs-5 mb-5 px-md-5">
                    Merci pour votre commande chez <strong style="color: var(--anthracite);">Vite & Gourmand</strong>. Votre paiement a bien été validé et notre équipe a été notifiée pour la préparation.
                </p>

                <!-- Boutons d'actions -->
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('customer.order-details', $commandeId) }}" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-eye me-2"></i>Voir le détail de ma commande
                    </a>
                    <a href="{{ url('/menus') }}" class="btn btn-success px-4 py-2" style="background-color: var(--vert-sauge); border-color: var(--vert-sauge);">
                        <i class="bi bi-plus-circle me-2"></i>Faire une nouvelle commande
                    </a>
                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-arrow-left me-2"></i>Retour à mes commandes
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
