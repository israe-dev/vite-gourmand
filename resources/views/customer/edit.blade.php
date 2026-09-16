@extends('layouts.main-site')

@section('title', 'Modifier une commande — Vite & Gourmand')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 fw-bold text-dark mb-1">Modifier ma commande</h1>
                            <p class="text-muted mb-0">Commande #{{ $commande->id }}</p>
                        </div>
                        <a href="{{ route('customer.order-details', $commande->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.orders.update', $commande->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="menu_id" class="form-label">Choisir un menu</label>
                                <select name="menu_id" id="menu_id" class="form-select" required>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}" {{ $commande->menu_id == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->titre }} — {{ number_format($menu->prix_par_personne, 2, ',', ' ') }} €/pers
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nombre_personnes" class="form-label">Nombre de personnes</label>
                                <input type="number" name="nombre_personnes" id="nombre_personnes" class="form-control" min="1" value="{{ old('nombre_personnes', $commande->nombre_personnes) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="date_prestation" class="form-label">Date de prestation</label>
                                <input type="date" name="date_prestation" id="date_prestation" class="form-control" value="{{ old('date_prestation', $commande->date_prestation) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="heure_livraison" class="form-label">Heure de livraison</label>
                                <input type="time" name="heure_livraison" id="heure_livraison" class="form-control" value="{{ old('heure_livraison', $commande->heure_livraison) }}" required>
                            </div>

                            <div class="col-12">
                                <label for="lieu_livraison" class="form-label">Lieu / adresse de livraison</label>
                                <textarea name="lieu_livraison" id="lieu_livraison" class="form-control" rows="3" required>{{ old('lieu_livraison', $commande->lieu_livraison) }}</textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">Enregistrer les modifications</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
