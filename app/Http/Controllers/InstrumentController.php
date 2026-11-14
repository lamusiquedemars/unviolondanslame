<?php

namespace App\Http\Controllers;

use App\Modules\Pages\Models\Page;
use App\Modules\SiteSettings\Models\SiteSetting;
use App\Support\Modules;
use Illuminate\View\View;
use Maracuja\SiteCore\Catalogue\Models\CatalogueItem;

class InstrumentController extends Controller
{
    public function index(): View
    {
        return view('site.pages.instruments', [
            'settings' => SiteSetting::current(),
            'page' => Modules::enabled('pages')
                ? Page::query()->where('slug', 'instruments')->where('is_published', true)->first()
                : null,
            'instruments' => CatalogueItem::query()->public()
                ->whereHas('collection', fn ($query) => $query->where('slug', 'instruments')->where('is_published', true))
                ->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $instrument = CatalogueItem::query()->public()
            ->where('slug', $slug)
            ->whereHas('collection', fn ($query) => $query->where('slug', 'instruments')->where('is_published', true))
            ->firstOrFail();

        return view('site.instruments.show', [
            'settings' => SiteSetting::current(),
            'instrument' => $instrument,
        ]);
    }
}
