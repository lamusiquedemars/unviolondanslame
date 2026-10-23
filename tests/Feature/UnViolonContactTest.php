<?php

namespace Tests\Feature;

use App\Modules\Inquiries\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnViolonContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_displays_the_workshop_details_and_no_fake_photo_upload(): void
    {
        config(['maracuja.theme' => 'unviolondanslame']);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('David Gellé, luthier')
            ->assertSee('13 rue Hector Berlioz')
            ->assertSee('06 51 25 54 15')
            ->assertSee('Accueil uniquement sur rendez-vous.')
            ->assertDontSee('type="file"', false)
            ->assertSee('https://www.google.com/maps/dir/?api=1&amp;destination=', false);
    }

    public function test_contact_form_stores_a_real_inquiry_with_the_selected_subject(): void
    {
        config(['maracuja.modules.contact_form' => true, 'maracuja.modules.inquiries' => true]);

        $this->post('/contact', [
            'name' => 'Camille Martin',
            'email' => 'camille@example.test',
            'phone' => '0612345678',
            'subject' => 'repair',
            'message' => 'Mon violon a besoin d’être réglé.',
        ])->assertRedirect('/contact');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Camille Martin',
            'email' => 'camille@example.test',
            'subject' => 'Réparation',
        ]);
    }
}
