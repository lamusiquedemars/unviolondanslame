<?php

namespace App\Http\Controllers;

use App\Modules\Pages\Models\Page;
use App\Modules\SiteSettings\Models\SiteSetting;
use App\Support\Modules;
use Illuminate\View\View;
use Maracuja\SiteCore\Instruments\Models\PublishedInstrument;

class InstrumentController extends Controller
{
    public function index(): View
    {
        return view('site.pages.instruments', [
            'settings' => SiteSetting::current(),
            'page' => Modules::enabled('pages')
                ? Page::query()->where('slug', 'instruments')->where('is_published', true)->first()
                : null,
            'instruments' => PublishedInstrument::query()->publicCatalogue()->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $instrument = PublishedInstrument::query()->where('slug', $slug)->firstOrFail();

        abort_if($instrument->publication_status === 'withdrawn', 410);
        abort_unless(PublishedInstrument::query()->whereKey($instrument)->publicCatalogue()->exists(), 404);

        return view('site.instruments.show', [
            'settings' => SiteSetting::current(),
            'instrument' => $instrument,
        ]);
    }
}
