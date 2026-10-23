<?php

namespace Tests\Feature;

use App\Filament\Resources\SiteSettings\Pages\ManageSiteSettings;
use App\Models\User;
use App\Modules\SiteSettings\Models\SiteSetting;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SiteSettingsResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_administrator_can_save_a_baseline_and_social_links(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'is_admin' => true]);
        $settings = SiteSetting::current();

        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(ManageSiteSettings::class)
            ->callTableAction('edit', $settings, [
                'site_name' => $settings->site_name,
                'baseline' => 'Une baseline enregistrée',
                'social_links' => ['Instagram' => 'https://www.instagram.com/unviolondanslame/'],
            ])
            ->assertHasNoTableActionErrors();

        $settings->refresh();

        $this->assertSame('Une baseline enregistrée', $settings->baseline);
        $this->assertSame(['Instagram' => 'https://www.instagram.com/unviolondanslame/'], $settings->social_links);
    }

    public function test_the_theme_uses_the_saved_baseline_and_instagram_link(): void
    {
        config(['maracuja.theme' => 'unviolondanslame']);

        SiteSetting::current()->update([
            'baseline' => 'Le geste juste',
            'social_links' => ['Instagram' => 'https://www.instagram.com/unviolondanslame/'],
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Le geste juste')
            ->assertSee('https://www.instagram.com/unviolondanslame/', false);
    }
}
