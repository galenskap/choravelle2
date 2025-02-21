<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class HCaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => config('services.hcaptcha.secret'),
            'response' => $value,
        ]);

        if (!$response->successful() || !$response->json('success')) {
            $fail('La vérification anti-robot a échoué. Veuillez réessayer.');
        }
    }
} 