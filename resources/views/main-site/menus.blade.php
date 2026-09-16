@extends('layouts.main-site')

@section('title', 'Nos Menus | Vite & Gourmand')

@section('content')
<style>
    .menu-card { border: none; border-radius: 15px; overflow: hidden; background: white; transition: transform 0.3s ease; }
    .menu-card:hover { transform: translateY(-5px); }
    .card-carousel { height: 250px; }
    .card-carousel img { height: 250px; width: 100%; object-fit: cover; }
    .badge-custom { position: absolute; top: 15px; left: 15px; z-index: 10; background: #6B8E23; color: white; padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; }
    .btn-details { background-color: #E2725B; color: white; border: none; font-weight: 600; padding: 10px 0; border-radius: 6px; width: 100%; transition: 0.3s; }
    .btn-details:hover { background-color: #c55a39; color: white; }
</style>

<section class="py-5 bg-light">
    <div class="container">
        
        {{-- En-tête de la page --}}
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold" style="font-family: 'Playfair Display', serif;">Découvrez notre Carte</h2>
            <p class="text-muted">Explorez nos créations culinaires et filtrez-les selon vos envies en temps réel.</p>
        </div>

        {{-- FORMULAIRE DE FILTRAGE DYNAMIQUE --}}
        <div class="card shadow-sm p-4 mb-5 bg-white border-0" style="border-radius: 15px;">
            <form id="filter-form" action="{{ route('menus') }}" method="GET" class="row g-3">
                
                <div class="col-md-4">
                    <label for="recherche" class="form-label fw-bold text-secondary">Rechercher un menu</label>
                    <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Ex: Jardin, Éclat, Salade...">
                </div>

                <div class="col-md-4">
                    <label for="theme_id" class="form-label fw-bold text-secondary">Thématique</label>
                    <select name="theme_id" id="theme_id" class="form-select">
                        <option value="">Tous les thèmes</option>
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="prix_max" class="form-label fw-bold text-secondary">Prix max par personne</label>
                    <input type="number" name="prix_max" id="prix_max" class="form-control" placeholder="Ex: 30" min="0" step="0.5">
                </div>

            </form>
        </div>

        {{-- GRILLE DES MENUS (Mise à jour par JS) --}}
        <div class="row g-4" id="menus-container">
            {{-- Inclusion directe des cartes lors du premier chargement --}}
            @include('partials.menu-cards')
        </div>

    </div>
</section>

{{-- Modal de Commande Rapide --}}
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div>
                    <h5 class="modal-title fw-bold" id="orderModalLabel">Commander : <span id="modal-menu-title" class="text-primary"></span></h5>
                    <p class="small text-muted mb-0">Ajustez les détails de votre prestation avant de valider.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form method="POST" action="{{ route('order.store') }}">
                @csrf
                <input type="hidden" name="menu_id" id="modal_menu_id">

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modal_nom" class="form-label">Nom</label>
                            <input type="text" id="modal_nom" class="form-control" value="{{ Auth::user()->nom ?? '' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_prenom" class="form-label">Prénom</label>
                            <input type="text" id="modal_prenom" class="form-control" value="{{ Auth::user()->prenom ?? '' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_email" class="form-label">Email</label>
                            <input type="email" id="modal_email" class="form-control" value="{{ Auth::user()->email ?? '' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_telephone" class="form-label">Téléphone</label>
                            <input type="text" id="modal_telephone" class="form-control" value="{{ Auth::user()->telephone ?? '' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_nombre_personnes" class="form-label">Nombre de personnes *</label>
                            <input type="number" name="nombre_personnes" id="modal_nombre_personnes" class="form-control" required>
                            <small id="modal-minimum-info" class="text-muted d-block mt-1"></small>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_date_prestation" class="form-label">Date de prestation *</label>
                            <input type="date" name="date_prestation" id="modal_date_prestation" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_heure_livraison" class="form-label">Heure de livraison *</label>
                            <input type="time" name="heure_livraison" id="modal_heure_livraison" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_lieu_livraison" class="form-label">Adresse de livraison *</label>
                            <textarea name="lieu_livraison" id="modal_lieu_livraison" class="form-control" rows="1" required></textarea>
                            <div id="modal-delivery-info" class="mt-1 text-sm"></div>
                        </div>

                        <div class="col-12">
                            <label for="modal_complement_adresse" class="form-label">Complément d'adresse</label>
                            <input type="text" name="complement_adresse" id="modal_complement_adresse" class="form-control" placeholder="Bâtiment, étage...">
                        </div>

                        <div class="col-12">
                            <div class="card p-3 bg-light border-0 mt-2">
                                <h6 class="fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Détail de la commande</h6>

                                <div id="modal-row-menu-raw" class="d-flex justify-content-between text-muted" style="display: none;">
                                    <span>Prix du menu (<span id="modal-summary-nb-persons">0</span> pers.)</span>
                                    <span id="modal-summary-raw-price">0,00 €</span>
                                </div>

                                <div id="modal-row-discount" class="d-flex justify-content-between text-success fw-bold mt-1" style="display: none;">
                                    <span><i class="bi bi-tag-fill me-1"></i>Remise grand groupe (-10 %)</span>
                                    <span id="modal-summary-discount-amount">-0,00 €</span>
                                </div>

                                <div class="d-flex justify-content-between fw-bold mt-2">
                                    <span>Sous-total menu</span>
                                    <span id="modal-summary-menu-final">0,00 €</span>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <span>Livraison</span>
                                    <span id="modal-summary-shipping-fee" data-value="5.00">5,00 €</span>
                                </div>

                                <hr class="my-2">

                                <div class="d-flex justify-content-between fs-5 fw-bold text-primary">
                                    <span>Total TTC</span>
                                    <span id="modal-summary-total-price">0,00 €</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Continuer à comparer</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> Valider la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT FETCH POUR LE FILTRAGE EN TEMPS RÉEL --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const container = document.getElementById('menus-container');

    function fetchMenus() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`${form.action}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.html;
        })
        .catch(error => console.error('Erreur lors du filtrage :', error));
    }

    if (form) {
        form.addEventListener('input', fetchMenus);
        form.addEventListener('change', fetchMenus);
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentUnitPrice = 0;
    let currentMinPersons = 1;
    let currentMaxStock = 999;

    const modalMenuTitle = document.getElementById('modal-menu-title');
    const modalMenuId = document.getElementById('modal_menu_id');
    const personsInput = document.getElementById('modal_nombre_personnes');
    const minInfo = document.getElementById('modal-minimum-info');
    const addressInput = document.getElementById('modal_lieu_livraison');
    const infoDiv = document.getElementById('modal-delivery-info');
    const shippingSpan = document.getElementById('modal-summary-shipping-fee');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    function formatEuros(val) {
        return Number(val).toFixed(2).replace('.', ',') + ' €';
    }

    function calculateModalTotals() {
        const count = parseInt(personsInput.value || 0);
        const rawMenuPrice = currentUnitPrice * count;
        let discount = 0;

        const rowMenuRaw = document.getElementById('modal-row-menu-raw');
        const rowDiscount = document.getElementById('modal-row-discount');

        if ((count - currentMinPersons) >= 5) {
            discount = rawMenuPrice * 0.10;
            rowMenuRaw.style.setProperty('display', 'flex', 'important');
            rowDiscount.style.setProperty('display', 'flex', 'important');

            document.getElementById('modal-summary-nb-persons').textContent = count;
            document.getElementById('modal-summary-raw-price').textContent = formatEuros(rawMenuPrice);
            document.getElementById('modal-summary-discount-amount').textContent = '-' + formatEuros(discount);
        } else {
            rowMenuRaw.style.setProperty('display', 'none', 'important');
            rowDiscount.style.setProperty('display', 'none', 'important');
        }

        const finalMenuPrice = rawMenuPrice - discount;
        document.getElementById('modal-summary-menu-final').textContent = formatEuros(finalMenuPrice);

        const shippingFee = parseFloat(shippingSpan.dataset.value || 5.00);
        const grandTotal = finalMenuPrice + shippingFee;

        document.getElementById('modal-summary-total-price').textContent = formatEuros(grandTotal);
    }

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.btn-open-order-modal');
        if (!button) return;

        const menuId = button.dataset.menuId;
        const title = button.dataset.menuTitle;
        currentUnitPrice = parseFloat(button.dataset.menuPrice || 0);
        currentMinPersons = parseInt(button.dataset.menuMin || 1);
        currentMaxStock = parseInt(button.dataset.menuStock || 999);

        modalMenuId.value = menuId;
        modalMenuTitle.textContent = title;

        personsInput.min = currentMinPersons;
        personsInput.max = currentMaxStock;
        personsInput.value = currentMinPersons;

        minInfo.textContent = `Minimum obligatoire : ${currentMinPersons} pers. (Stock max : ${currentMaxStock})`;

        calculateModalTotals();
    });

    if (personsInput) {
        personsInput.addEventListener('input', calculateModalTotals);
    }

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
                    'X-CSRF-TOKEN': csrfToken
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
                    
                    const cleanedPrice = String(data.prix_livraison).replace(/\s/g, '').replace(',', '.').trim();
                    const fee = parseFloat(cleanedPrice) || 0;

                    shippingSpan.dataset.value = fee;
                    shippingSpan.textContent = formatEuros(fee);
                    calculateModalTotals();
                }
            })
            .catch(error => {
                if (infoDiv) infoDiv.innerHTML = `<span class="text-danger">${error.message}</span>`;
            });
        });
    }
});
</script>
@endsection