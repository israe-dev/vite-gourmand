<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeliveryFeeService
{
    protected float $baseFee = 5.00;
    protected float $ratePerKm = 0.59;
    
    // Point de repère pour les coordonnées de Bordeaux Centre
    protected float $bordeauxLat = 44.837789;
    protected float $bordeauxLon = -0.579180;

    // il calcule la zone, la distance et le prix total de la livraison
    public function calculate(string $address): array
    {
        // il nettoie l'adresse pour enlever les espaces en trop ou les retours à la ligne
        $cleanAddress = trim(preg_replace('/\s+/', ' ', $address));

        $client = Http::when(app()->isLocal(), function ($request) {
            return $request->withoutVerifying();
        });

        // Étape 1 : il récupère les coordonnées GPS de l'adresse grâce à Nominatim
        $geoResponse = $client->withHeaders([
            'User-Agent' => 'ViteEtGourmandApp/1.0 (contact@vite-et-gourmand.fr)'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $cleanAddress,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 1,
        ]);

        if ($geoResponse->failed() || empty($geoResponse->json())) {
            throw new \InvalidArgumentException("L'adresse saisie n'a pas pu être géolocalisée. Veuillez préciser la rue et le code postal.");
        }

        $geoData = $geoResponse->json()[0];
        $destLat = (float) $geoData['lat'];
        $destLon = (float) $geoData['lon'];

        // Étape 2 : il vérifie si on est bien dans Bordeaux ou son code postal
        $addressDetails = $geoData['address'] ?? [];
        $city = mb_strtolower($addressDetails['city'] ?? $addressDetails['town'] ?? $addressDetails['village'] ?? '');
        $postcode = $addressDetails['postcode'] ?? '';

        $isBordeaux = ($city === 'bordeaux') || preg_match('/^33[0-8]00$/', $postcode);

        if ($isBordeaux) {
            return [
                'zone'           => 'Bordeaux',
                'distance_km'    => 0,
                'prix_livraison' => $this->baseFee,
            ];
        }

        // Étape 3 : Si c'est hors de Bordeaux, il calcule la vraie distance routière avec OSRM
        $osrmUrl = "https://router.project-osrm.org/route/v1/driving/{$this->bordeauxLon},{$this->bordeauxLat};{$destLon},{$destLat}?overview=false";
        $osrmResponse = $client->get($osrmUrl);

        if ($osrmResponse->failed() || ($osrmResponse->json()['code'] ?? '') !== 'Ok') {
            throw new \RuntimeException("Impossible de calculer la distance de livraison pour cette adresse.");
        }

        $distanceMeters = $osrmResponse->json()['routes'][0]['distance'];
        $distanceKm = round($distanceMeters / 1000, 1);

        $prixLivraison = round($this->baseFee + ($distanceKm * $this->ratePerKm), 2);

        return [
            'zone'           => 'Hors Bordeaux',
            'distance_km'    => $distanceKm,
            'prix_livraison' => $prixLivraison,
        ];
    }
}