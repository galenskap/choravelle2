<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactSubmission;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'page_id' => 'required|exists:pages,id'
        ]);

        $submission = ContactSubmission::create($validated);

        // Envoyer l'email aux administrateurs
        Mail::to(config('mail.admin_address'))->send(new NewContactSubmission($submission));

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
} 