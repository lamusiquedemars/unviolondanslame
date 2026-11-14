<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $collectionId = DB::table('catalogue_collections')->insertGetId([
            'name' => 'Instruments de l’atelier', 'slug' => 'instruments',
            'singular_label' => 'Instrument', 'plural_label' => 'Instruments',
            'description' => 'Violons et archets sélectionnés, disponibles à l’essai sur rendez-vous.',
            'source' => 'local', 'is_published' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach (['Violons', 'Archets'] as $position => $name) {
            DB::table('catalogue_categories')->insert(['catalogue_collection_id' => $collectionId, 'name' => $name,
                'slug' => str($name)->slug(), 'sort_order' => $position, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        DB::table('catalogue_collections')->where('slug', 'instruments')->delete();
    }
};
