<?php

namespace Tests\Feature;

use App\Modules\Pages\Models\Page;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnViolonHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_four_sections_and_safe_links_without_unbuilt_pages(): void
    {
        $this->withoutVite();
        config(['maracuja.theme' => 'unviolondanslame', 'maracuja.seo.indexable' => false]);

        Page::query()->create([
            'title' => 'Services', 'slug' => 'services',
            'template' => 'services', 'is_published' => true,
        ]);

        $response = $this->get('/')->assertOk()
            ->assertSee("Luthier à Décines-Charpieu | Un violon dans l'âme")
            ->assertSee('noindex, nofollow')
            ->assertSee('Photographie à venir')
            ->assertDontSee('Actualités démo')
            ->assertDontSee('Prêt pour une démo client');

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
        $xpath = new DOMXPath($dom);
        $this->assertSame(1, $xpath->query('//h1')->length);
        $this->assertSame(4, $xpath->query('//main/section')->length);
        $this->assertSame(5, $xpath->query('//nav/a')->length);
        $this->assertSame(0, $xpath->query('//main//form | //main//video')->length);

        foreach ($xpath->query('//main//a | //nav/a') as $link) {
            $href = $link->getAttribute('href');
            $this->assertNotSame('', $href);
            if (str_starts_with($href, '#')) {
                $this->assertSame(1, $xpath->query('//*[@id="'.substr($href, 1).'"]')->length);
            } else {
                $this->get($href)->assertOk();
            }
        }
    }

    public function test_photographs_replace_placeholders_with_responsive_loading(): void
    {
        config(['unviolondanslame.photos.hero' => [
            'src' => '/images/atelier.webp',
            'srcset' => '/images/atelier-640.webp 640w, /images/atelier.webp 1200w',
            'alt' => 'Le travail du chevalet à l’établi',
        ]]);

        $this->blade('<x-unviolondanslame.photo name="hero" priority />')
            ->assertSee('loading="eager"', false)
            ->assertSee('fetchpriority="high"', false)
            ->assertSee('srcset=', false)
            ->assertSee('Le travail du chevalet à l’établi')
            ->assertDontSee('Photographie à venir');

        $this->blade('<x-unviolondanslame.photo name="hero" />')
            ->assertSee('loading="lazy"', false);
    }
}
