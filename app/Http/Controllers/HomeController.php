<?php

namespace App\Http\Controllers;

use App\Modules\News\Models\NewsPost;
use App\Modules\Notices\Models\SiteNotice;
use App\Modules\Pages\Models\Page;
use App\Modules\SiteSettings\Models\SiteSetting;
use App\Support\Modules;
use Illuminate\Contracts\View\View;
use Maracuja\SiteCore\Gallery\Models\Gallery;
use Maracuja\SiteCore\Media\Models\MediaAsset;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSetting::current();
        $homePage = Modules::enabled('pages')
            ? Page::query()->where('slug', 'accueil')->where('is_published', true)->first()
            : null;
        $servicesPage = Modules::enabled('pages')
            ? Page::query()->where('slug', 'services')->where('is_published', true)->first()
            : null;
        $gallery = Modules::enabled('gallery')
            ? Gallery::query()
                ->where('slug', config('maracuja.gallery.slug', 'home'))
                ->where('is_published', true)
                ->first()
            : null;

        $homeView = config('maracuja.theme') === 'unviolondanslame'
            ? 'site.themes.unviolondanslame.home'
            : 'site.home';
        $homePathMedia = collect(config('unviolondanslame.home_path_media', []));
        $homePathMedia = MediaAsset::query()
            ->whereKey($homePathMedia->filter())
            ->get()
            ->keyBy('id')
            ->pipe(fn ($mediaById) => collect(config('unviolondanslame.home_path_media', []))
                ->mapWithKeys(fn (int $mediaId, string $key) => [$key => $mediaById->get($mediaId)]));

        return view($homeView, [
            'settings' => $settings,
            'homePage' => $homePage,
            'contactUrl' => Modules::enabled('contact_form') ? route('contact') : null,
            'servicesUrl' => $servicesPage ? route('pages.show', $servicesPage->slug) : null,
            'instrumentsUrl' => route('instruments.index'),
            'atelierUrl' => route('pages.show', 'atelier'),
            'homePathMedia' => $homePathMedia,
            'homeNotice' => Modules::enabled('notices')
                ? SiteNotice::query()->visible()->forPlacement('home')->latest('starts_at')->first()
                : null,
            'newsPosts' => Modules::enabled('news')
                ? NewsPost::query()->forListing()->limit(3)->get()
                : collect(),
            'gallery' => $gallery,
            'galleryImages' => $gallery
                ? $gallery->images()->where('is_published', true)->limit(6)->get()
                : collect(),
        ]);
    }
}
