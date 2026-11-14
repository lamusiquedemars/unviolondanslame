<?php

namespace Tests\Feature;

use App\Modules\Gallery\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_slug_is_generated_from_title(): void
    {
        $gallery = Gallery::query()->create([
            'title' => 'Galerie Atelier',
        ]);

        $this->assertSame('galerie-atelier', $gallery->slug);
    }

    public function test_home_gallery_is_not_reserved_by_the_template(): void
    {
        $gallery = Gallery::query()->updateOrCreate(['slug' => 'home'], [
            'title' => 'Accueil',
        ]);

        $this->assertFalse($gallery->isSystemGallery());
    }
}
