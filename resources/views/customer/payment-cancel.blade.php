@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow p-5 mx-auto" style="max-width: 600px;">
        <div class="mb-4 text-warning">
            <h2>Paiement annulé ⚠️</h2>
        </div>
        <p class="text-muted mb-4">
            Vous avez interrompu le processus de paiement. Votre commande n'a pas été réglée, mais elle reste enregistrée dans vos commandes en attente si vous souhaitez réessayer.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('customer.orders') }}" class="btn btn-primary">
                Voir mes commandes
            </a>
        </div>
    </div>
</div>
@endsection