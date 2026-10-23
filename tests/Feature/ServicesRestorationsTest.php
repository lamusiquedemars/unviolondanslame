<?php

namespace Tests\Feature;

use App\Modules\Gallery\Models\Gallery;
use App\Modules\Gallery\Models\GalleryImage;
use App\Modules\Pages\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesRestorationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_hides_restorations_until_a_published_image_exists(): void
    {
        $this->servicesPage();
        Gallery::query()->create(['title' => 'Restauration sans photo', 'slug' => 'sans-photo', 'is_published' => true]);

        $this->get('/services')->assertOk()->assertDontSee('Quelques restaurations')->assertDontSee('Restauration sans photo');
    }

    public function test_services_limits_visible_restorations_to_four(): void
    {
        $this->servicesPage();

        foreach (range(1, 5) as $position) {
            $gallery = Gallery::query()->create(['title' => "Restauration {$position}", 'slug' => "restauration-{$position}", 'position' => $position, 'is_published' => true]);
            GalleryImage::query()->create(['gallery_id' => $gallery->id, 'title' => "Photo {$position}", 'image_path' => "galleries/restauration-{$position}/photo.jpg", 'is_published' => true]);
        }

        $this->get('/services')->assertOk()
            ->assertSee('Restauration 1')->assertSee('Restauration 4')->assertDontSee('Restauration 5');
    }

    private function servicesPage(): void
    {
        Page::query()->create(['title' => 'Services', 'slug' => 'services', 'template' => 'services', 'is_published' => true]);
    }
}
