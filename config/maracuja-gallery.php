<?php

// Transition : les migrations historiques de cette instance restent la
// référence. Le package partagé les utilise sans recréer les tables.
return [
    'load_migrations' => false,
    'system_slug' => config('maracuja.gallery.slug', 'home'),
    'max_user_galleries' => 4,
    'legacy_disk' => 'public',
];
