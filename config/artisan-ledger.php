<?php

return [
    /*
    | I canali di ingresso predefiniti.
    | Puoi aggiungerne quanti ne vuoi senza cambiare il database.
    */
    'channels' => [
        'cash' => [
            'label' => 'Contanti',
            'icon'  => 'banknotes',
        ],
        'pos' => [
            'label' => 'POS / Carte',
            'icon'  => 'credit-card',
        ],
        'invoice' => [
            'label' => 'Fatture Incassate',
            'icon'  => 'document-text',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Theme
    |--------------------------------------------------------------------------
    | Scegli il tema da caricare. Assicurati che esista la cartella
    | corrispondente in resources/views/themes/
    */
    'theme' => env('ARTISAN_LEDGER_THEME', 'default'),
];
