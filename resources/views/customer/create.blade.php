@extends('layouts.main-site')

@section('title', 'Passer une commande — Vite & Gourmand')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 fw-bold text-dark mb-1">Passer une commande</h1>
                            <p class="text-muted mb-0">Renseignez votre prestation et votre lieu de livraison.</p>
                        </div>
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary btn-sm">
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

                    <form method="POST" action="{{ route('order.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" id="nom" class="form-control" value="{{ old('nom', Auth::user()->nom ?? '') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" id="prenom" class="form-control" value="{{ old('prenom', Auth::user()->prenom ?? '') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" id="telephone" class="form-control" value="{{ old('telephone', Auth::user()->telephone ?? '') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="menu_id" class="form-label">Choisir un menu</label>
                                <select name="menu_id" id="menu_id" class="form-select" required>
                                    <option value="">Sélectionner un menu</option>
                                    @foreach($menus as $menu)
                                        <option
                                            value="{{ $menu->id }}"
                                            data-price="{{ $menu->prix_par_personne }}"
                                            data-min="{{ $menu->nb_personne_minimum }}"
                                            {{ old('menu_id', $selectedMenuId ?? '') == $menu->id ? 'selected' : '' }}
                                        >
                                            {{ $menu->titre }} — {{ number_format($menu->prix_par_personne, 2, ',', ' ') }} €/pers
                                            (min. {{ $menu->nb_personne_minimum }} pers)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nombre_personnes" class="form-label">Nombre de personnes</label>
                                <input
                                    type="number"
                                    name="nombre_personnes"
                                    id="nombre_personnes"
                                    class="form-control"
                                    min="1"
                                    value="{{ old('nombre_personnes', 10) }}"
                                    required
                                >
                                <small id="minimum-info" class="text-muted d-block mt-1">Sélectionnez un menu.</small>
                            </div>

                            <div class="col-md-6">
                                <label for="date_prestation" class="form-label">Date de la prestation</label>
                                <input
                                    type="date"
                                    name="date_prestation"
                                    id="date_prestation"
                                    class="form-control"
                                    value="{{ old('date_prestation') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="heure_livraison" class="form-label">Heure de livraison</label>
                                <input
                                    type="time"
                                    name="heure_livraison"
                                    id="heure_livraison"
                                    class="form-control"
                                    value="{{ old('heure_livraison') }}"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="lieu_livraison" class="form-label">Adresse de livraison *</label>
                                <textarea
                                    name="lieu_livraison"
                                    id="lieu_livraison"
                                    class="form-control"
                                    rows="2"
                                    required
                                >{{ old('lieu_livraison') }}</textarea>
                                <div id="delivery-info" class="mt-1 text-sm"></div>
                            </div>

                            <div class="col-12">
                                <label for="complement_adresse" class="form-label">Complément d'adresse (Bâtiment, étage...)</label>
                                <input
                                    type="text"
                                    name="complement_adresse"
                                    id="complement_adresse"
                                    class="form-control"
                                    value="{{ old('complement_adresse') }}"
                                >
                            </div>

                            <div class="col-12">
                                <div class="card p-3 bg-light mt-4">
                                    <h5 class="mb-3 fw-bold">Résumé du prix</h5>

                                    <div id="row-menu-raw" class="d-flex justify-content-between text-muted" style="display: none;">
                                        <span>Prix du menu (<span id="summary-nb-persons">0</span> pers.)</span>
                                        <span id="summary-raw-price">0,00 €</span>
                                    </div>

                                    <div id="row-discount" class="d-flex justify-content-between text-success fw-bold mt-1" style="display: none;">
                                        <span>Remise grand groupe (-10 %)</span>
                                        <span id="summary-discount-amount">-0,00 €</span>
                                    </div>

                                    <div class="d-flex justify-content-between fw-bold mt-2">
                                        <span>Sous-total menu</span>
                                        <span id="summary-menu-final">0,00 €</span>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2">
                                        <span>Livraison</span>
                                        <span id="summary-shipping-fee" data-value="5.00">5,00 €</span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between fs-5 fw-bold text-primary">
                                        <span>Total</span>
                                        <span id="summary-total-price">0,00 €</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-check-circle me-2"></i>Valider la commande
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuSelect = document.getElementById('menu_id');
        const personsInput = document.getElementById('nombre_personnes');
        const addressInput = document.getElementById('lieu_livraison');
        const infoDiv = document.getElementById('delivery-info');
        const minimumInfo = document.getElementById('minimum-info');
        const shippingSpan = document.getElementById('summary-shipping-fee');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        function formatEuros(value) {
            return Number(value).toFixed(2).replace('.', ',') + ' €';
        }

        function calculateTotals() {
            const selectedOption = menuSelect?.options[menuSelect.selectedIndex];
            if (!selectedOption) return;

            const unitPrice = parseFloat(selectedOption.dataset.price || 0);
            const minPersons = parseInt(selectedOption.dataset.min || 10);
            const count = parseInt(personsInput.value || 0);

            if (personsInput && minPersons) {
                personsInput.min = minPersons;
            }

            const rawMenuPrice = unitPrice * count;
            let discount = 0;

            const rowMenuRaw = document.getElementById('row-menu-raw');
            const rowDiscount = document.getElementById('row-discount');

            if ((count - minPersons) >= 5) {
                discount = rawMenuPrice * 0.10;

                rowMenuRaw.style.setProperty('display', 'flex', 'important');
                rowDiscount.style.setProperty('display', 'flex', 'important');

                document.getElementById('summary-nb-persons').textContent = count;
                document.getElementById('summary-raw-price').textContent = formatEuros(rawMenuPrice);
                document.getElementById('summary-discount-amount').textContent = '-' + formatEuros(discount).replace(' €', '') + ' €';
            } else {
                rowMenuRaw.style.setProperty('display', 'none', 'important');
                rowDiscount.style.setProperty('display', 'none', 'important');
            }

            const finalMenuPrice = rawMenuPrice - discount;
            document.getElementById('summary-menu-final').textContent = formatEuros(finalMenuPrice);

            const currentShippingFee = parseFloat(shippingSpan.dataset.value || 5.00);
            const grandTotal = finalMenuPrice + currentShippingFee;

            document.getElementById('summary-total-price').textContent = formatEuros(grandTotal);

            if (minimumInfo) {
                minimumInfo.textContent = 'Minimum requis : ' + minPersons + ' personnes';
            }
        }

        if (menuSelect) menuSelect.addEventListener('change', calculateTotals);
        if (personsInput) personsInput.addEventListener('input', calculateTotals);

        if (addressInput) {
            addressInput.addEventListener('change', function () {
                const address = this.value.trim();
                if (address.length < 5) return;

                if (infoDiv) infoDiv.innerHTML = '<span class="text-info">Calcul des frais en cours...</span>';

                fetch("{{ route('customer.orders.estimate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({ lieu_livraison: address })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Erreur lors du calcul');
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        if (infoDiv) {
                            infoDiv.innerHTML = `<span class="text-success"><strong>Zone :</strong> ${data.zone} (${data.distance_km} km)</span>`;
                        }

                        const fee = parseFloat(data.prix_livraison.replace(',', '.'));
                        shippingSpan.dataset.value = fee;
                        shippingSpan.textContent = fee.toFixed(2).replace('.', ',') + ' €';

                        calculateTotals();
                    }
                })
                .catch(error => {
                    if (infoDiv) infoDiv.innerHTML = `<span class="text-danger">${error.message}</span>`;
                });
            });
        }

        calculateTotals();
    });
</script>
@endsection