<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Rate limiting par IP
        $key = 'lead-submission:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'error' => "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes."
            ]);
        }

        // Validation stricte
        $request->validate([
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:leads,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'feedback' => [
                'nullable',
                'string',
                'max:1000',
                'regex:/^[a-zA-Z0-9\s\p{L}\p{P}]*$/u' // Seulement lettres, chiffres, espaces et ponctuation
            ],
        ], [
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà enregistrée.',
            'email.regex' => 'Format d\'email invalide.',
            'feedback.regex' => 'Le feedback contient des caractères non autorisés.',
        ]);

        try {
            // Nettoyage des données
            $email = strtolower(trim($request->email));
            $feedback = $request->feedback ? strip_tags(trim($request->feedback)) : null;

            // Vérification supplémentaire de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors(['email' => 'Adresse email invalide.']);
            }

            $lead = Lead::create([
                'email' => $email,
                'feedback' => $feedback,
                'ip_address' => $request->ip(),
                'user_agent' => Str::limit($request->userAgent(), 500),
            ]);

            // Log de l'activité
            Log::info('New lead registered', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Marquer la tentative comme réussie
            RateLimiter::hit($key, 300); // 5 minutes

            return back()->with('success', 'Merci ! Nous vous tiendrons informé du lancement de WontanGo.');

        } catch (\Exception $e) {
            Log::error('Lead registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }
}
