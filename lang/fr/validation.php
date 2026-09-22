<?php

// Messages de validation (le reste retombe sur l'anglais par défaut de Laravel)
return [
    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'string' => 'Le champ :attribute doit être un texte.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'max' => [
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'file' => 'Le fichier :attribute ne peut pas dépasser :max Ko.',
    ],
    'image' => 'Le fichier :attribute doit être une image.',

    'attributes' => [
        'name' => 'nom',
        'email' => 'e-mail',
        'phone' => 'téléphone',
        'service_id' => 'service',
        'message' => 'message',
    ],
];
