<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Maracuja\SiteCore\Catalogue\Models\CatalogueCollection;
use Maracuja\SiteCore\Catalogue\Models\CatalogueItem;
use Tests\TestCase;

class InstrumentCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_local_catalogue_shows_published_instruments_and_bows(): void
    {
        config(['maracuja.theme' => 'unviolondanslame']);
        $collection = CatalogueCollection::query()->where('slug', 'instruments')->firstOrFail();
        CatalogueItem::query()->create([
            'catalogue_collection_id' => $collection->id, 'slug' => 'violon-atelier',
            'title' => 'Violon de l’atelier', 'publication_status' => 'published', 'availability' => 'available',
        ]);
        CatalogueItem::query()->create([
            'catalogue_collection_id' => $collection->id, 'slug' => 'archet-vendu',
            'title' => 'Archet vendu', 'publication_status' => 'published', 'availability' => 'sold',
        ]);
        CatalogueItem::query()->create([
            'catalogue_collection_id' => $collection->id, 'slug' => 'brouillon',
            'title' => 'Brouillon', 'publication_status' => 'draft',
        ]);

        $this->get('/instruments')->assertOk()->assertSee('Violon de l’atelier')->assertSee('Archet vendu')->assertDontSee('Brouillon');
        $this->get('/instruments/violon-atelier')->assertOk()->assertSee('Violon de l’atelier');
        $this->postJson('/api/internal/cremona/instruments', [])->assertNotFound();
    }
}
