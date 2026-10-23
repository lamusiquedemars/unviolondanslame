@extends('layouts.site', [
    'seoTitle' => $instrument->name . " | Un violon dans l’âme",
    'seoDescription' => $instrument->description,
])

@section('content')
    @php
        $photos = collect($instrument->media)->filter(fn ($media) => filled($media['url'] ?? null));
        $characteristics = collect($instrument->attributes)->map(function ($attribute, $key) {
            if (! is_array($attribute)) return ['label' => $key, 'value' => $attribute];
            if (! ($attribute['is_public'] ?? false)) return null;
            $label = ($attribute['label'] ?? null) === '__other__' ? ($attribute['custom_label'] ?? null) : ($attribute['label'] ?? null);
            return filled($label) && filled($attribute['value'] ?? null) ? ['label' => $label, 'value' => $attribute['value']] : null;
        })->filter();
        $contactUrl = route('contact', ['subject' => 'Essai — '.$instrument->name, 'instrument' => $instrument->cremona_id]);
    @endphp
    <section class="uv-instrument-detail">
        <div class="container uv-instrument-detail__hero">
            <div>
                <p class="eyebrow">{{ $instrument->family ?: 'Instrument' }}</p>
                <h1>{{ $instrument->name }}</h1>
                @if ($instrument->maker)<p class="uv-instrument-detail__maker">{{ $instrument->maker }}</p>@endif
                <p class="uv-instrument-detail__price">{{ $instrument->displayPrice() }}</p>
                @if ($instrument->isSold())<p class="uv-instrument-detail__sold">Cet instrument est vendu.</p>@endif
                @if ($instrument->description)<p class="uv-instrument-detail__description">{{ $instrument->description }}</p>@endif
                <x-site.button :href="$contactUrl">{{ $instrument->isSold() ? 'Chercher un instrument similaire' : 'Demander un essai' }}</x-site.button>
            </div>
            @if ($hero = $photos->first())
                <figure><img src="{{ $hero['url'] }}" alt="{{ $hero['alt'] ?? $hero['caption'] ?? $instrument->name }}"></figure>
            @endif
        </div>
    </section>
    @if ($characteristics->isNotEmpty())
        <x-site.section title="Caractéristiques"><dl class="uv-instrument-specs">@foreach ($characteristics as $item)<div><dt>{{ $item['label'] }}</dt><dd>{{ $item['value'] }}</dd></div>@endforeach</dl></x-site.section>
    @endif
    @if ($photos->count() > 1)
        <x-site.section title="Photos de l’instrument"><div class="uv-instrument-photos" data-lightbox>@foreach ($photos as $photo)<a href="{{ $photo['url'] }}" data-pswp-width="{{ $photo['width'] ?? 1200 }}" data-pswp-height="{{ $photo['height'] ?? 1600 }}"><img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] ?? $photo['caption'] ?? $instrument->name }}" loading="lazy"></a>@endforeach</div></x-site.section>
    @endif
@endsection
