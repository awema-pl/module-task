<?php

return [
    'admin' => [
        'installation' =>[
            'meta_title' => 'Instalacja modułu kolejek',
            'headline' => 'Instalacja modułu kolejek',
            'meta_description' => 'Instalacja modułu kolejek w aplikacji',
            'send_text' => 'Instaluj',
            'will_be_execute_migrations' => 'Migracje pakietu zostaną uruchomione',
        ],
        'setting'=>[
            'meta_title' => 'Ustawienia',
            'headline' => 'Ustawienia',
            'meta_description' => 'Ustawienia kolejek w systemie.',
            'settings' =>'Ustawienia',
            'key' =>'Klucz',
            'value' =>'Wartość',
            'edit_account' => 'Edycja konta',
            'options' =>'Opcje',
            'edit' =>'Edytuj',
            'save' => 'Zapisz',
        ],
    ],
    'user' => [
        'status'=>[
            'meta_title' => 'Statusy',
            'headline' => 'Statusy',
            'meta_description' => 'Statusy zadań w systemie.',
            'statuses' =>'Statusy',
            'type' => 'Rodzaj',
            'interrupted' => 'Przerwano',
            'status' => 'Status',
            'error' => 'Błąd',
            'created_at' =>'Utworzono',
            'options' =>'Opcje',
            'show_error' => 'Pokaż błąd',
            'interrupt' => 'Przerwij zadanie',
            'are_you_sure_interrupt_status'=>'Czy na pewno przerwać zadanie?',
            'confirm' =>'Potwierdź',
            'statuses'=>[
                  'queued' => 'w kolejce',
                  'executing' => 'wykonywane',
                  'finished'=>'zakończone',
                  'failed' => 'nie powiodło się',
            ]
        ],
    ],
];
