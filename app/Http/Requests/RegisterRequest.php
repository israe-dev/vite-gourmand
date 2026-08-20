<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        return true; // À mettre sur true pour autoriser l'inscription publique
    }

    /**
     * Obtenir les règles de validation applicables à la requête.
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:utilisateurs,email'],
            'password' => [
                            'required',
                            'string',
                            'min:10',             // 10 caractères minimum
                            'regex:/[a-z]/',      // Au moins une minuscule
                            'regex:/[A-Z]/',      // Au moins une majuscule
                            'regex:/[0-9]/',      // Au moins un chiffre
                            'regex:/[@$!%*#?&]/', // Au moins un caractère spécial
                            'confirmed'           // Doit correspondre au champ password_confirmation
                        ],
        ];
    }

    /**
     * Obtenir les messages d'erreur personnalisés pour les règles définies.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le champ nom est obligatoire.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'telephone.required' => 'Le numéro de téléphone mobile (GSM) est obligatoire.',
            'adresse.required' => "L'adresse postale de livraison est obligatoire.",
            'email.required' => "L'adresse email est obligatoire.",
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà associée à un compte.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 10 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
        ];
    }
}