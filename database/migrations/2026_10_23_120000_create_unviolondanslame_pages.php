<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (app()->environment('testing')) return;

        foreach ([
            ['title' => 'Services', 'slug' => 'services', 'template' => 'services', 'type' => 'system', 'hero_title' => 'Prendre soin de votre instrument', 'hero_subtitle' => 'Réparation, restauration, réglage et entretien.', 'seo_title' => 'Services de lutherie | Un violon dans l’âme', 'seo_description' => 'Réparation, restauration, réglage et entretien des instruments du quatuor.', 'is_published' => true],
            ['title' => 'L’atelier', 'slug' => 'atelier', 'template' => 'atelier', 'type' => 'system', 'hero_title' => 'Un atelier au service de la musique', 'hero_subtitle' => 'Un lieu d’écoute, de travail et de transmission.', 'seo_title' => 'L’atelier | Un violon dans l’âme', 'seo_description' => 'Découvrez l’atelier de David, luthier à Décines-Charpieu.', 'is_published' => true],
            ['title' => 'Instruments', 'slug' => 'instruments', 'template' => 'module', 'type' => 'module', 'hero_title' => 'Instruments à découvrir', 'hero_subtitle' => 'Une sélection d’instruments préparés pour être essayés à l’atelier.', 'seo_title' => 'Instruments | Un violon dans l’âme', 'seo_description' => 'Instruments sélectionnés par David, luthier à Décines-Charpieu.', 'is_published' => true],
        ] as $page) DB::table('pages')->updateOrInsert(['slug' => $page['slug']], $page + ['published_at' => now(), 'created_at' => now(), 'updated_at' => now()]);
    }
    public function down(): void
    {
        if (! app()->environment('testing')) DB::table('pages')->whereIn('slug', ['services', 'atelier', 'instruments'])->delete();
    }
};
