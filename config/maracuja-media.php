<?php

// Transition : les migrations historiques de cette instance restent la
// référence. Le package partagé les utilise sans recréer les tables.
return [
    'load_migrations' => false,
    'public_disk' => env('MARACUJA_MEDIA_PUBLIC_DISK', 'public'),
    'originals_disk' => env('MARACUJA_MEDIA_ORIGINALS_DISK', 'local'),
    'processing_disk' => env('MARACUJA_MEDIA_PROCESSING_DISK', 'local'),
];
