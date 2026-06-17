@extends('layouts.main-site')

@section('title', 'Politique de Confidentialité & RGPD | Vite & Gourmand')

@section('content')
<style>
    .rgpd-container {
        background-color: #FFFDF8;
        padding: 60px 0;
        color: #4A4A4A;
    }
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
    .rgpd-section {
        margin-bottom: 40px;
    }
    .rgpd-section h2 {
        color: var(--vert-sauge);
        font-weight: 700;
        margin-bottom: 20px;
        border-bottom: 2px solid #F8F1E7;
        padding-bottom: 10px;
    }
    .rgpd-table th {
        background-color: var(--vert-sauge);
        color: white;
    }
</style>

<div class="rgpd-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-5 text-center">
                    <h1 class="display-5 font-serif fw-bold" style="color: var(--marron-doux);">Politique de Protection des Données Personnelles (RGPD)</h1>
                    <p class="text-muted lead">Dernière mise à jour : Juin 2026</p>
                    <p class="mt-3">Chez <strong>Vite & Gourmand</strong>, nous accordons une importance capitale à la confidentialité et à la sécurité des données de nos clients à Bordeaux et ses alentours. Cette politique vous informe sur la manière dont nous traitons vos données conformément au Règlement Général sur la Protection des Données (RGPD).</p>
                </div>

                <div class="rgpd-section">
                    <h2>1. Responsable du traitement des données</h2>
                    <p>Les données personnelles collectées sur ce site sont traitées conjointement par Julie et José, fondateurs de l'entreprise <strong>Vite & Gourmand</strong>, dont les ateliers sont situés au 123 Cours de la Marne, 33000 Bordeaux.</p>
                </div>

                <div class="rgpd-section">
                    <h2>2. Les données que nous collectons</h2>
                    <p>Dans le cadre de l’utilisation de notre application de restauration et traiteur, nous sommes amenés à collecter les catégories de données suivantes :</p>
                    <ul>
                        <li><strong>Données d'identification :</strong> Nom, prénom.</li>
                        <li><strong>Données de contact :</strong> Adresse e-mail, numéro de téléphone (GSM).</li>
                        <li><strong>Données de livraison et facturation :</strong> Adresse postale complète, date, heure et lieu de la prestation culinaire.</li>
                        <li><strong>Données d'authentification :</strong> Mot de passe chiffré de manière sécurisée (10 caractères minimum comprenant majuscule, minuscule, chiffre et caractère spécial).</li>
                    </ul>
                </div>

                <div class="rgpd-section">
                    <h2>3. Finalités et bases légales du traitement</h2>
                    <p>Le tableau ci-dessous synthétise pourquoi nous collectons vos données et le fondement juridique de ce traitement :</p>
                    
                    <div class="table-responsive my-3">
                        <table class="table table-bordered rgpd-table">
                            <thead>
                                <tr>
                                    <th>Finalité du traitement</th>
                                    <th>Données concernées</th>
                                    <th>Base légale (RGPD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Gestion des commandes :</strong> Enregistrement, suivi de l'état de préparation, calcul des frais de livraison hors-Bordeaux et facturation.</td>
                                    <td>Nom, prénom, adresse, téléphone, détails du menu.</td>
                                    <td>Exécution d'un contrat</td>
                                </tr>
                                <tr>
                                    <td><strong>Traitement des demandes de contact :</strong> Réponses aux questions sur les allergènes, les régimes spécifiques ou les demandes de devis sur-mesure.</td>
                                    <td>Titre de la demande, description, e-mail.</td>
                                    <td>Consentement de l'utilisateur (Case à cocher obligatoire)</td>
                                </tr>
                                <tr>
                                    <td><strong>Création et gestion du compte client :</strong> Accès à l'espace utilisateur pour le suivi logistique ou le dépôt d'avis validés.</td>
                                    <td>E-mail (username), mot de passe chiffré.</td>
                                    <td>Exécution d'un contrat / Intérêt légitime</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rgpd-section">
                    <h2>4. Durée de conservation des données</h2>
                    <p>Nous veillons à ne conserver vos données que le temps strictement nécessaire aux opérations pour lesquelles elles ont été collectées :</p>
                    <ul>
                        <li><strong>Données de compte et de contrat :</strong> Conservées pendant toute la durée de la relation commerciale, puis archivées pendant 5 ans pour répondre aux obligations comptables et légales.</li>
                        <li><strong>Données du formulaire de contact :</strong> Conservées pendant une durée maximale de 3 ans à compter du dernier échange commercial.</li>
                        <li><strong>Avis clients :</strong> Conservés sur la page d'accueil tant que le menu associé est proposé par l'atelier, sauf demande de suppression par l'utilisateur.</li>
                    </ul>
                </div>

                <div class="rgpd-section">
                    <h2>5. Destinataires des données</h2>
                    <p>Vos données personnelles sont strictement confidentielles. Elles sont exclusivement destinées à :</p>
                    <ul>
                        <li>L'équipe interne de <strong>Vite & Gourmand</strong> (Julie, José, et les équipes de cuisine ou logistique en charge des livraisons).</li>
                        <li>Notre prestataire technique informatique <strong>FastDev</strong>, uniquement pour les besoins stricts de maintenance technique de l'application de démonstration.</li>
                    </ul>
                    <p>Aucune donnée n'est vendue, cédée ou transmise à des tiers ou à des courtiers de données à des fins publicitaires.</p>
                </div>

                <div class="rgpd-section">
                    <h2>6. Sécurité des données</h2>
                    <p>Conformément aux exigences de sécurité informatique requises pour l’obtention de notre infrastructure de confiance, nous mettons en œuvre des mesures strictes :</p>
                    <ul>
                        <li>Chiffrement fort des mots de passe en base de données.</li>
                        <li>Utilisation du protocole sécurisé HTTPS pour empêcher l’interception des formulaires de commande ou de contact.</li>
                        <li>Contrôle d'accès rigoureux aux espaces d’administration de l'application (Espace Administrateur et Espace Employé).</li>
                    </ul>
                </div>

                <div class="rgpd-section">
                    <h2>7. Vos Droits Informatique et Libertés</h2>
                    <p>Conformément au RGPD, vous disposez de droits complets sur vos données personnelles :</p>
                    <ul>
                        <li><strong>Droit d'accès et de rectification :</strong> Vous pouvez à tout moment modifier vos informations personnelles depuis votre Espace Utilisateur.</li>
                        <li><strong>Droit à l'effacement (« droit à l'oubli ») :</strong> Vous pouvez demander la suppression définitive de votre compte client.</li>
                        <li><strong>Droit d'opposition et de retrait du consentement :</strong> Vous pouvez retirer votre consentement au traitement de vos messages ou demandes de contact.</li>
                    </ul>
                    <p>Pour exercer ces droits, vous pouvez contacter directement l'équipe de Vite & Gourmand via notre <a href="{{ url('/contact') }}" style="color: #D96C4A; fw-bold">Page de Contact</a> ou par e-mail à <code>contact@viteetgourmand.fr</code>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection