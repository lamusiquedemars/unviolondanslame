@extends('layouts.site', [
    'brandName' => "Un violon dans l'âme",
    'seoTitle' => "Luthier à Décines-Charpieu | Un violon dans l'âme",
    'seoDescription' => 'Atelier de lutherie à Décines-Charpieu : réparation, restauration, réglage, entretien, vente et location de violons, altos, violoncelles et contrebasses.',
    'seoImage' => $homePage?->heroImageUrl() ?? config('unviolondanslame.photos.hero.src'),
])

@section('site-header')
    <a class="uv-skip" href="#contenu">Aller au contenu</a>
    <header class="site-header container uv-header" data-nav>
        <a class="site-brand" href="{{ route('home') }}" aria-label="Un violon dans l’âme — Accueil">
            <span><strong>Un violon dans l'âme</strong><small>{{ $settings->baseline ?: 'Atelier de lutherie' }}</small></span>
        </a>
        <button class="btn btn--secondary nav-toggle" data-nav-toggle type="button" aria-controls="navigation-atelier" aria-expanded="false">Menu</button>
        <nav class="site-nav" id="navigation-atelier" data-nav-menu aria-label="Navigation principale">
            <a href="{{ $servicesUrl ?? '#services' }}">Services de lutherie</a>
            <a href="{{ $instrumentsUrl }}">Instruments</a>
            <a href="{{ $atelierUrl }}">L'atelier</a>
            <a href="{{ $contactUrl }}">Contact</a>
        </nav>
    </header>
@endsection
@section('content')
    <section class="section uv-hero" aria-labelledby="accueil-titre">
        <div class="container split">
            <div class="uv-hero__text">
                <p class="eyebrow">Atelier de lutherie · Décines-Charpieu</p>
                <h1 id="accueil-titre">Un violon dans l'âme</h1>
                <p class="uv-hero__promise">Au service des instruments<br class="uv-desktop-break"> et de ceux qui les font vivre.</p>
                <p class="uv-hero__description">Dans mon atelier à Décines-Charpieu, je règle, entretiens, répare et restaure violons, altos, violoncelles et contrebasses. Je propose aussi des instruments à la vente et à la location, et vous reçois sur rendez-vous.</p>
                <div class="cluster uv-actions">
                    <x-site.button :href="$contactUrl">Prendre rendez-vous</x-site.button>
                    <x-site.button :href="$servicesUrl ?? '#services'" variant="secondary">Découvrir les services</x-site.button>
                </div>
            </div>
            @if ($heroMedia = $homePage?->heroMedia)
                <figure class="uv-photo uv-hero__photo">
                    <img src="{{ $heroMedia->url() }}"
                        @if ($heroMedia->srcset()) srcset="{{ $heroMedia->srcset() }}" sizes="(max-width: 800px) 100vw, 50vw" @endif
                        alt="{{ $heroMedia->alt_text }}" width="{{ $heroMedia->width }}" height="{{ $heroMedia->height }}"
                        loading="eager" fetchpriority="high" decoding="async">
                </figure>
            @else
                <x-unviolondanslame.photo name="hero" priority class="uv-hero__photo" />
            @endif
        </div>
    </section>

    <x-site.section class="uv-paths" aria-label="Votre besoin">
        @php
            $servicesPhoto = $homePathMedia->get('services');
            $instrumentsPhoto = $homePathMedia->get('instruments');
            $atelierPhoto = $homePathMedia->get('atelier');
            $workbenchPhoto = $homePathMedia->get('workbench');
        @endphp

        <x-site.grid columns="3">
            <article class="uv-path" id="services">
                @if ($servicesPhoto)
                    <figure class="uv-photo">
                        <x-site.image :src="$servicesPhoto->url()" :srcset="$servicesPhoto->srcset()" sizes="(max-width: 700px) 100vw, 33vw" alt="Réparation et réglage d’instruments à l’atelier" :width="$servicesPhoto->width" :height="$servicesPhoto->height" />
                    </figure>
                @else
                    <x-unviolondanslame.photo name="services" sizes="(max-width: 700px) 100vw, 33vw" />
                @endif
                <div class="uv-path__body">
                    <h2>Réparer ou régler</h2>
                    <p>Un problème de sonorité, un instrument abîmé, un archet à remécher ? Je vous accompagne dans l’entretien et la remise en état de votre instrument.</p>
                    <a class="uv-text-link" href="{{ $servicesUrl ?? $contactUrl }}">Voir les services <span aria-hidden="true">↗</span></a>
                </div>
            </article>
            <article class="uv-path" id="instruments">
                @if ($instrumentsPhoto)
                    <figure class="uv-photo">
                        <x-site.image :src="$instrumentsPhoto->url()" :srcset="$instrumentsPhoto->srcset()" sizes="(max-width: 700px) 100vw, 33vw" alt="Instrument à louer ou à acheter" :width="$instrumentsPhoto->width" :height="$instrumentsPhoto->height" />
                    </figure>
                @else
                    <x-unviolondanslame.photo name="instruments" sizes="(max-width: 700px) 100vw, 33vw" />
                @endif
                <div class="uv-path__body">
                    <h2>Louer ou acheter</h2>
                    <p>Pour les premiers pas comme pour la suite de votre parcours musical, je vous propose de découvrir les instruments disponibles à l’atelier.</p>
                    <a class="uv-text-link" href="{{ $instrumentsUrl }}">Voir les instruments <span aria-hidden="true">↗</span></a>
                </div>
            </article>
            <article class="uv-path">
                @if ($atelierPhoto)
                    <figure class="uv-photo">
                        <x-site.image :src="$atelierPhoto->url()" :srcset="$atelierPhoto->srcset()" sizes="(max-width: 700px) 100vw, 33vw" alt="Établi et outils de l’atelier de David Gellé" :width="$atelierPhoto->width" :height="$atelierPhoto->height" />
                    </figure>
                @else
                    <x-unviolondanslame.photo name="atelier" sizes="(max-width: 700px) 100vw, 33vw" />
                @endif
                <div class="uv-path__body">
                    <h2>Découvrir l'atelier</h2>
                    <p>Je vous invite à découvrir mon parcours, mon atelier et ma manière de travailler.</p>
                    <a class="uv-text-link" href="{{ $atelierUrl }}">Découvrir l'atelier <span aria-hidden="true">↗</span></a>
                </div>
            </article>
        </x-site.grid>
    </x-site.section>

    <x-site.section class="uv-work" id="atelier" aria-labelledby="atelier-titre">
        <div class="split">
            @if ($workbenchPhoto)
                <figure class="uv-photo">
                    <x-site.image :src="$workbenchPhoto->url()" :srcset="$workbenchPhoto->srcset()" sizes="(max-width: 800px) 100vw, 50vw" alt="Travail à l’établi dans l’atelier de David Gellé" :width="$workbenchPhoto->width" :height="$workbenchPhoto->height" />
                </figure>
            @else
                <x-unviolondanslame.photo name="travail" />
            @endif
            <div class="uv-work__text">
                <h2 id="atelier-titre">Le soin apporté<br> à chaque instrument</h2>
                <p>Chaque instrument possède son caractère, sa sonorité, son histoire. Avant d’intervenir, j’en observe l’état et les particularités, avec une attention portée au confort de jeu et aux attentes du musicien.</p>
                <p>Du simple réglage aux travaux de restauration, je prends soin des instruments du quatuor et des archets.</p>
                <p class="uv-work__aside">Je répare également certains instruments traditionnels, notamment le kamantcha et l’oud.</p>
                <x-site.button :href="$atelierUrl" variant="secondary">Découvrir mon travail</x-site.button>
            </div>
        </div>
    </x-site.section>

    <x-site.section class="uv-contact" aria-labelledby="contact-titre">
        <div class="uv-contact__inner">
            <h2 id="contact-titre">Parlons de votre instrument</h2>
            <p>Un réglage à prévoir, une réparation à envisager, un instrument à essayer ?</p>
            <p>Écrivez-moi pour en parler et convenir d’un rendez-vous à l’atelier.</p>
            <div class="cluster cluster--center uv-actions">
                <x-site.button :href="$contactUrl">Prendre rendez-vous</x-site.button>
            </div>
        </div>
    </x-site.section>
@endsection
