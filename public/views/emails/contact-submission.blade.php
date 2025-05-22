@component('mail::message')
# Nouveau message de contact

**Nom :** {{ $submission->name }}  
**Email :** {{ $submission->email }}  
**Téléphone :** {{ $submission->phone }}

**Message :**  
{{ $submission->message }}

@component('mail::button', ['url' => config('app.url')])
Voir dans l'administration
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent 