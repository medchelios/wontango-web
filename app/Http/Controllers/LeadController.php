<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:leads,email',
            'feedback' => 'nullable|string|max:1000',
        ]);

        try {
            $lead = Lead::create([
                'email' => $request->email,
                'feedback' => $request->feedback,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->with('success', 'Merci ! Nous vous tiendrons informé du lancement de WontanGo.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }
}
