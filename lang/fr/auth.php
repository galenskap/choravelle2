<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'failed' => 'Ces informations d\'identification ne correspondent pas à nos enregistrements.',
    'password' => [
        'reset' => 'Votre mot de passe a été réinitialisé !',
        'sent' => 'Nous vous avons envoyé par email le lien de réinitialisation du mot de passe !',
        'throttled' => 'Veuillez patienter avant de réessayer.',
        'token' => 'Ce jeton de réinitialisation du mot de passe n\'est pas valide.',
        'user' => 'Aucun utilisateur n\'a été trouvé avec cette adresse email.',
    ],
    'reset_password' => [
        'subject' => 'Notification de réinitialisation du mot de passe',
        'greeting' => 'Bonjour !',
        'line_1' => 'Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.',
        'action' => 'Réinitialiser le mot de passe',
        'line_2' => 'Ce lien de réinitialisation expirera dans :count minutes.',
        'line_3' => 'Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune action n\'est requise.',
    ],
    'throttle' => 'Trop de tentatives de connexion. Veuillez essayer de nouveau dans :seconds secondes.',

];