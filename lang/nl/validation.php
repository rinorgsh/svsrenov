<?php

// Validatieberichten (de rest valt terug op de standaard Engelse teksten van Laravel)
return [
    'required' => 'Het veld :attribute is verplicht.',
    'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
    'string' => 'Het veld :attribute moet tekst zijn.',
    'exists' => 'De gekozen waarde voor :attribute is ongeldig.',
    'max' => [
        'string' => 'Het veld :attribute mag niet meer dan :max tekens bevatten.',
        'file' => 'Het bestand :attribute mag niet groter zijn dan :max kB.',
    ],
    'image' => 'Het bestand :attribute moet een afbeelding zijn.',

    'attributes' => [
        'name' => 'naam',
        'email' => 'e-mail',
        'phone' => 'telefoon',
        'service_id' => 'dienst',
        'message' => 'bericht',
    ],
];
