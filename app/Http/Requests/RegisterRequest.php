<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Autoriser tout le monde à soumettre ce formulaire d'inscription
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Les règles de validation strictes et sécurisées
     */
    public function rules(): array
    {
        return [
            'prenom'    => 'required|string|max:255',
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:utilisateurs,email',
            'telephone' => 'required|string|max:20',
            'adresse'   => 'required|string|max:255',
            'password'  => 'required|string|min:8', 
            // Note : Si ton HTML possède un champ de confirmation de mot de passe, 
            // on pourra ajouter '|confirmed' à la règle ci-dessus.
        ];
    }

    /**
     * Nettoyage et formatage des données AVANT la validation (Ultra Pro)
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'prenom' => ucwords(strtolower($this->prenom)), // "jean-pierre" -> "Jean-Pierre"
            'nom'    => strtoupper($this->nom),            // "dupont" -> "DUPONT"
            'email'  => strtolower($this->email),          // "USER@Email.Com" -> "user@email.com"
        ]);
    }

    /**
     * Messages d'erreur personnalisés et clairs en français pour l'ECF
     */
    public function messages(): array
    {
        return [
            'prenom.required'    => 'Le prénom est obligatoire.',
            'nom.required'       => 'Le nom de famille est obligatoire.',
            
            'email.required'     => 'L\'adresse e-mail est obligatoire.',
            'email.email'        => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique'       => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
            
            'gsm.required' => 'Le numéro de téléphone est obligatoire.',
            'adresse.required'   => 'L\'adresse postale est obligatoire.',
            
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Pour votre sécurité, le mot de passe doit contenir au moins 8 caractères.',
        ];
    }
}