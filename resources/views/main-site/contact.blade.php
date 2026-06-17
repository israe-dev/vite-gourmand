@extends('layouts.main-site')

@section('title', 'Contactez-nous | Vite & Gourmand')

@section('content')
<style>
    .contact-container {
        background-color: #FFFDF8;
        padding: 60px 0;
    }
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
    .info-box {
        background-color: #F8F1E7; /* Beige Crème */
        border-radius: 16px;
        padding: 40px;
    }
    .icon-circle {
        width: 50px;
        height: 50px;
        background-color: var(--vert-sauge);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.25rem;
    }
    .btn-submit {
        background-color: #D96C4A; /* Terracotta */
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 30px;
        border: none;
        transition: background 0.3s, transform 0.2s;
    }
    .btn-submit:hover {
        background-color: #c55a39;
        color: white;
        transform: translateY(-2px);
    }
    .form-control:focus {
        border-color: var(--vert-sauge);
        box-shadow: 0 0 0 0.25rem rgba(120, 132, 117, 0.25);
    }
</style>

<div class="contact-container">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-5 font-serif fw-bold" style="color: var(--marron-doux);">Une question ? Un événement à organiser ?</h1>
            <p class="text-muted lead">L'équipe de Vite & Gourmand est à votre écoute pour régaler vos convives à Bordeaux et ses alentours.</p>
        </div>

        <div class="row g-5 mt-3">
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                    <h2 class="h3 font-serif fw-bold mb-4" style="color: var(--vert-sauge);">Envoyez-nous un message</h2>
                    
                    <form action="#" method="POST" novalidate>
                        @csrf <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label small fw-bold text-muted">Nom *</label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" required placeholder="Votre nom">
                            </div>
                            <div class="col-md-6">
                                <label for="prenom" class="form-label small fw-bold text-muted">Prénom *</label>
                                <input type="text" class="form-control form-control-lg" id="prenom" name="prenom" required placeholder="Votre prénom">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-bold text-muted">Adresse e-mail *</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required placeholder="nom@exemple.com">
                            </div>
                            <div class="col-md-6">
                                <label for="telephone" class="form-label small fw-bold text-muted">Téléphone</label>
                                <input type="tel" class="form-control form-control-lg" id="telephone" name="telephone" placeholder="06 00 00 00 00">
                            </div>
                        </div>

                        <div class="mb-3 mt-4">
                            <label for="sujet" class="form-label small fw-bold text-muted">Sujet de votre demande *</label>
                            <select class="form-select form-control-lg" id="sujet" name="sujet" required>
                                <option value="" selected disabled>Choisissez une option...</option>
                                <option value="evenement">Demande de devis (Événement / Traiteur)</option>
                                <option value="regime">Question sur nos menus adaptés (Régimes / Allergènes)</option>
                                <option value="commande">Suivi d'une commande passée</option>
                                <option value="autre">Autre demande générale</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label small fw-bold text-muted">Votre message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Détaillez votre demande ici (date de l'événement, nombre de personnes...)"></textarea>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-check input form-check-input" type="checkbox" id="rgpd" name="rgpd" required style="cursor: pointer;">
                            <label class="form-check-label small text-muted" for="rgpd" style="cursor: pointer; user-select: none;">
                                En soumettant ce formulaire, j'accepte que les informations saisies soient exploitées par Vite & Gourmand dans le cadre exclusif de ma demande et de la relation commerciale qui peut en découler. *
                            </label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-submit px-5 py-3 shadow-sm">
                                <i class="bi bi-send-fill me-2"></i> Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="info-box h-100 shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="h3 font-serif fw-bold mb-4" style="color: var(--marron-doux);">Nos Coordonnées</h2>
                        <p class="text-muted mb-5">Julie et José vous accueillent dans leurs ateliers pour concevoir vos projets culinaires sur-mesure.</p>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-circle me-3 flex-shrink-0">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-1">Notre Atelier</h4>
                                <p class="text-muted small mb-0">123 Cours de la Marne,<br>33000 Bordeaux</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-circle me-3 flex-shrink-0">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-1">Téléphone</h4>
                                <p class="text-muted small mb-0">05 56 00 00 00 (Du lundi au samedi)</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-circle me-3 flex-shrink-0">
                                <i class="bi bi-envelope-open-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-1">Adresse Email</h4>
                                <p class="text-muted small mb-0">contact@viteetgourmand.fr</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-circle me-3 flex-shrink-0">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-1">Horaires d'ouverture</h4>
                                <p class="text-muted small mb-0">Lun - Ven : 8h00 - 19h00<br>Samedi : 9h00 - 17h00</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <img src="https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?auto=format&fit=crop&q=80&w=500" 
                             class="img-fluid rounded-3 shadow-sm w-100" 
                             style="height: 180px; object-fit: cover;" 
                             alt="Atelier Vite et Gourmand Bordeaux">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection