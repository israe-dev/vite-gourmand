<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Afficher le profil client
    public function index()
    {
        $user = Auth::user();
        return view('customer.account', compact('user'));
    }

    // Mettre à jour les informations du profil
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:utilisateurs,email,' . $user->id,
        ]);

        $user->update($request->only('nom', 'prenom', 'email'));

        return redirect()->route('customer.account')->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}