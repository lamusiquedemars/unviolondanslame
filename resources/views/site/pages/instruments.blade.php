@extends('layouts.site', [
    'seoTitle' => $page?->seo_title ?? "Instruments | Un violon dans l’âme",
    'seoDescription' => $page?->seo_description ?? 'Instruments sélectionnés par David, luthier à Décines-Charpieu.',
])

@section('content')
    <x-site.hero eyebrow="Instruments" :title="$page?->hero_title ?? 'Instruments à découvrir'"
        :subtitle="$page?->hero_subtitle ?? 'Une sélection d’instruments préparés pour être essayés à l’atelier.'" />

    <x-site.section title="La sélection de l’atelier" intro="Chaque instrument présenté est disponible à l’essai sur rendez-vous.">
        <div class="uv-instrument-grid">
            @forelse ($instruments as $instrument)
                @php($photo = collect($instrument->media)->first(fn ($media) => filled($media['url'] ?? null)))
                <article class="uv-instrument-card {{ $instrument->isSold() ? 'is-sold' : '' }}">
                    <a href="{{ route('instruments.show', $instrument->slug) }}" aria-label="Voir {{ $instrument->name }}">
                        <div class="uv-instrument-card__media">
                            @if ($photo)
                                <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] ?? $photo['caption'] ?? $instrument->name }}" loading="lazy">
                            @else
                                <span>Photographie à venir</span>
                            @endif
                        </div>
                        <div class="uv-instrument-card__content">
                            <p>{{ $instrument->family ?: 'Instrument' }}</p>
                            <h2>{{ $instrument->name }}</h2>
                            @if ($instrument->maker)<span>{{ $instrument->maker }}</span>@endif
                            <strong>{{ $instrument->displayPrice() }}</strong>
                            @if ($instrument->isSold())<em>Vendu</em>@endif
                        </div>
                    </a>
                </article>
            @empty
                <p>Aucun instrument n’est actuellement présenté. Contactez David pour préparer votre recherche.</p>
            @endforelse
        </div>
    </x-site.section>
@endsection
