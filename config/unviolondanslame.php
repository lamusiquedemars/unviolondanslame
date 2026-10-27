<?php

return [
    'workshop' => [
        'name' => "Un violon dans l’âme",
        'owner' => 'David Gellé',
        'address_lines' => ['13 rue Hector Berlioz', '69150 Décines-Charpieu'],
        'phone_display' => '06 51 25 54 15',
        'phone_href' => '+33651255415',
        'directions_url' => 'https://www.google.com/maps/dir/?api=1&destination=13%20Rue%20Hector%20Berlioz%2C%2069150%20D%C3%A9cines-Charpieu',
    ],

    'atelier_media' => [
        'working' => 2,
        'samvel' => 4,
        'bench' => 5,
    ],

    'home_path_media' => [
        'services' => 15,
        'instruments' => 12,
        'atelier' => 13,
        'workbench' => 16,
    ],

    // Local public URLs only. Supply authentic photographs before publication.
    // Each photo accepts src, srcset (optional), and a descriptive alt text.
    'photos' => [
        'hero' => ['src' => null, 'alt' => '', 'label' => 'Au cœur de la lutherie'],
        'services' => ['src' => null, 'alt' => '', 'label' => 'Le geste et la matière'],
        'instruments' => ['src' => null, 'alt' => '', 'label' => 'Des instruments à découvrir'],
        'atelier' => ['src' => null, 'alt' => '', 'label' => 'L’atelier de David'],
        'travail' => ['src' => null, 'alt' => '', 'label' => 'À l’établi'],
        'david' => ['src' => null, 'alt' => '', 'label' => 'David Gellé, luthier'],
    ],
];
