<?php

namespace App\Http\Controllers;

use App\Modules\Pages\Models\Page;
use App\Modules\Gallery\Models\Gallery;
use App\Modules\SiteSettings\Models\SiteSetting;
use App\Support\Modules;
use Illuminate\Contracts\View\View;
use Maracuja\SiteCore\Media\Models\MediaAsset;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        abort_unless(Modules::enabled('pages'), 404);

        $page = Page::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        abort_if($page->isModule(), 404);

        if ($page->isText()) {
            $view = 'site.page';
        } else {
            $view = view()->exists("site.pages.{$page->template}")
                ? "site.pages.{$page->template}"
                : 'site.page';
        }

        $atelierMedia = collect();

        if ($page->slug === 'atelier') {
            $configuredMedia = config('unviolondanslame.atelier_media', []);
            $mediaById = MediaAsset::query()
                ->whereKey(array_filter($configuredMedia))
                ->get()
                ->keyBy('id');

            $atelierMedia = collect($configuredMedia)
                ->mapWithKeys(fn (int $mediaId, string $key) => [$key => $mediaById->get($mediaId)]);
        }

        return view($view, [
            'settings' => SiteSetting::current(),
            'page' => $page,
            'contactUrl' => Modules::enabled('contact_form') ? route('contact') : null,
            'atelierMedia' => $atelierMedia,
            'restorationGalleries' => $page->slug === 'services' && Modules::enabled('gallery')
                ? Gallery::query()->where('slug', '!=', config('maracuja.gallery.slug', 'home'))
                    ->where('is_published', true)
                    ->whereHas('images', fn ($query) => $query->where('is_published', true)
                        ->where(fn ($query) => $query->whereNotNull('media_asset_id')->orWhereNotNull('image_path')))
                    ->with(['images' => fn ($query) => $query
                        ->where('is_published', true)
                        ->where(fn ($query) => $query->whereNotNull('media_asset_id')->orWhereNotNull('image_path'))
                        ->with('media')
                        ->orderBy('position')])
                    ->orderBy('position')
                    ->limit((int) config('maracuja.gallery.restoration_limit', 4))
                    ->get()
                : collect(),
        ]);
    }
}
