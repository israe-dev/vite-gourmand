<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    // On autorise tout le monde à s'inscrire (accès public)
    public function authorize(): bool
    {
        return true;
    }

    // Définition des règles de validation pour chaque champ du formulaire
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
                        'min:10',            // 10 caractères minimum requis
                        'regex:/[a-z]/',      // Doit contenir une minuscule
                        'regex:/[A-Z]/',      // Doit contenir une majuscule
                        'regex:/[0-9]/',      // Doit contenir un chiffre
                        'regex:/[@$!%*#?&]/', // Doit contenir un caractère spécial
                        'confirmed'           // Vérifie que la confirmation du mot de passe est identique
                    ],
        ];
    }

    // Personnalisation des messages d'erreur en français
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