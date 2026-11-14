<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $galleryId = DB::table('galleries')->where('slug', 'home')->value('id');

        if ($galleryId === null) {
            return;
        }

        DB::table('gallery_images')->where('gallery_id', $galleryId)->delete();
        DB::table('galleries')->where('id', $galleryId)->delete();
    }

    public function down(): void
    {
        // The removed rows were template demonstration data; never recreate them.
    }
};
