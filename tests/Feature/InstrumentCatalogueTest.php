<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Maracuja\SiteCore\Instruments\Models\PublishedInstrument;
use Tests\TestCase;

class InstrumentCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_public_catalogue_shows_available_and_explicitly_visible_sold_instruments(): void
    {
        config(['maracuja.theme' => 'unviolondanslame']);
        PublishedInstrument::query()->create($this->instrument(['cremona_id' => 1, 'slug' => 'alto-disponible', 'name' => 'Alto disponible']));
        PublishedInstrument::query()->create($this->instrument(['cremona_id' => 2, 'slug' => 'violon-vendu', 'name' => 'Violon vendu', 'availability' => 'sold', 'show_when_sold' => true]));
        PublishedInstrument::query()->create($this->instrument(['cremona_id' => 3, 'slug' => 'violoncelle-retire', 'name' => 'Violoncelle retiré', 'publication_status' => 'withdrawn']));

        $this->get('/instruments')->assertOk()->assertSee('Alto disponible')->assertSee('Violon vendu')->assertDontSee('Violoncelle retiré');
        $this->get('/instruments/violon-vendu')->assertOk()->assertSee('Cet instrument est vendu.');
        $this->get('/instruments/violoncelle-retire')->assertStatus(410);
    }

    public function test_cremona_projection_requires_a_configured_bearer_token(): void
    {
        config(['maracuja-instruments.projection_token' => 'projection-secret']);
        $payload = $this->instrument(['cremona_id' => 44, 'slug' => 'violon-test']);
        $payload['id'] = $payload['cremona_id'];
        unset($payload['cremona_id'], $payload['withdrawn_at']);

        $this->postJson('/api/internal/cremona/instruments', $payload)->assertForbidden();
        $this->withToken('projection-secret')->postJson('/api/internal/cremona/instruments', $payload)->assertCreated();
        $this->assertDatabaseHas('published_instruments', ['cremona_id' => 44, 'slug' => 'violon-test']);
    }

    private function instrument(array $overrides = []): array
    {
        return $overrides + [
            'cremona_id' => 99,
            'slug' => 'instrument-test',
            'name' => 'Instrument test',
            'family' => 'Violon',
            'maker' => 'Atelier',
            'description' => 'Description publique.',
            'price_label' => '2 400',
            'sale_amount' => null,
            'attributes' => [],
            'media' => [],
            'availability' => 'available',
            'publication_status' => 'published',
            'show_when_sold' => false,
            'published_at' => now(),
        ];
    }
}
