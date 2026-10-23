@extends('layouts.site', [
    'seoTitle' => $page->seo_title ?? "Services de lutherie | Un violon dans l’âme",
    'seoDescription' => $page->seo_description ?? 'Réparation, restauration, réglage et entretien des instruments du quatuor à Décines-Charpieu.',
    'seoImage' => $page->heroImageUrl(),
])

@section('content')
    <x-site.hero
        eyebrow="Services de lutherie"
        :title="$page->hero_title ?? 'Prendre soin de votre instrument'"
        :subtitle="$page->hero_subtitle ?? 'Réparation, restauration, réglage et entretien des instruments du quatuor et des archets.'"
        :image="$page->heroImageUrl()"
        :cta-url="$contactUrl"
        cta-label="Contacter David"
    />

    <x-site.section title="À l’atelier">
        <x-site.grid columns="3">
            <x-site.card title="Réglage et entretien" kicker="Au quotidien">Pour retrouver le confort de jeu, la justesse et la réponse que vous attendez de votre instrument.</x-site.card>
            <x-site.card title="Réparation" kicker="Avec attention">Une intervention adaptée à l’état de l’instrument, à son usage et à son histoire.</x-site.card>
            <x-site.card title="Restauration" kicker="Dans le respect">Préserver les matières, les traces du temps et les qualités musicales de l’instrument.</x-site.card>
        </x-site.grid>
    </x-site.section>

    @if ($restorationGalleries->isNotEmpty())
        <x-site.section title="Quelques restaurations" intro="Des réalisations choisies dans l’atelier. Chaque galerie raconte une intervention, en images.">
            <div class="uv-restoration-list">
                @foreach ($restorationGalleries as $gallery)
                <article class="uv-restoration">
                    <div><p class="eyebrow">Restauration</p><h2>{{ $gallery->title }}</h2>@if ($gallery->intro)<p>{{ $gallery->intro }}</p>@endif</div>
                    <x-site.gallery :images="$gallery->images()->where('is_published', true)->get()" layout="featured" lightbox />
                </article>
                @endforeach
            </div>
        </x-site.section>
    @endif

    <x-site.section variant="surface"><x-site.cta title="Parlons de votre instrument" text="Expliquez votre besoin à David pour préparer un rendez-vous à l’atelier." :href="$contactUrl" label="Prendre rendez-vous" inline /></x-site.section>
@endsection
