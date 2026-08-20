@forelse($menus as $menu)
    <div class="col-md-4">
        <div class="card menu-card shadow-sm position-relative h-100 d-flex flex-column">
            
            {{-- Badge Régime dynamique si présent (ex: Végétarien, Végan, Classique...) --}}
            @if($menu->regime_id)
                <span class="badge-custom">Option Régime</span>
            @endif
            
            {{-- Carrousel d'images dynamique pour chaque menu --}}
           <div class="card-carousel">
    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500" alt="{{ $menu->titre }}" class="img-fluid">
</div>

            {{-- Corps de la carte --}}
            <div class="card-body p-4 text-center d-flex flex-column flex-grow-1">
                <h4 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">{{ $menu->titre }}</h4>
                <p class="small text-muted mb-2">{{ Str::limit($menu->description, 80) }}</p>
                <p class="small text-primary fw-bold mb-3">{{ $menu->prix_par_personne }}€ / pers.</p>
                
                <div class="mt-auto">
                    <p class="small text-muted mb-1">Minimum : <strong>{{ $menu->nb_personne_minimum }} pers.</strong></p>
                    <p class="small text-danger mb-3">Plus que <strong>{{ $menu->quantite_restante }}</strong> prestations dispos !</p>
                    <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-details d-block text-center text-decoration-none">Voir les détails</a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <p class="text-muted fs-5">Aucun menu ne correspond à vos critères de recherche pour le moment.</p>
    </div>
@endforelse