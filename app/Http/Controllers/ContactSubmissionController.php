<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use App\Rules\HCaptcha;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string',
            'page_id' => 'required|exists:pages,id',
            'h-captcha-response' => ['required', new HCaptcha],
        ]);

        $submission = ContactSubmission::create($validated);

        // Envoyer l'email à l'administrateur
        Mail::to(config('mail.admin.address'))->send(new ContactFormSubmitted($submission));

        return back()->with('success', 'Message envoyé avec succès !');
    }
} 