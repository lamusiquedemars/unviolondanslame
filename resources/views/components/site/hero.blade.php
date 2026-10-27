@props([
'eyebrow' => 'Maracuja CMS',
'title',
'subtitle' => null,
'ctaUrl' => null,
'ctaLabel' => null,
'secondaryCtaUrl' => null,
'secondaryCtaLabel' => null,
'variant' => null,
'image' => null,
'imageSources' => [],
'media' => null,
])

@php
    $imageSources = collect($imageSources)
        ->filter(fn ($url, $width): bool => is_numeric($width) && filled($url))
        ->mapWithKeys(fn ($url, $width): array => [(int) $width => $url])
        ->sortKeys();

    $heroStyles = $image ? ["--hero-image: url('{$image}')" => true] : [];

    foreach ($imageSources as $width => $url) {
        $heroStyles["--hero-image-{$width}: url('{$url}')"] = true;
    }

    if ($image && $imageSources->isEmpty()) {
        $heroStyles['background-image: var(--hero-image)'] = true;
    }
@endphp

<section
    {{ $attributes->class([
        'hero',
        'hero--' . $variant => $variant,
        'hero--image' => $image,
        'hero--responsive-image' => $imageSources->isNotEmpty(),
    ])->style($heroStyles) }}>
    <div class="hero__inner">
        <div class="hero__content">
            @if (! empty($eyebrow))
            <p class="eyebrow">{{ $eyebrow }}</p>
            @endif
            <h1>{{ $title }}</h1>
            @if (! empty($subtitle))
            <p class="hero__subtitle">{{ $subtitle }}</p>
            @endif
            @if ((! empty($ctaUrl) && ! empty($ctaLabel)) || (! empty($secondaryCtaUrl) && ! empty($secondaryCtaLabel)))
            <div class="hero__actions">
                @if (! empty($ctaUrl) && ! empty($ctaLabel))
                <a class="btn btn--primary" href="{{ $ctaUrl }}">{{ $ctaLabel }}</a>
                @endif
                @if (! empty($secondaryCtaUrl) && ! empty($secondaryCtaLabel))
                <a class="btn btn--secondary" href="{{ $secondaryCtaUrl }}">{{ $secondaryCtaLabel }}</a>
                @endif
            </div>
            @endif
        </div>

        @if ($media)
        <div class="hero__media">
            {{ $media }}
        </div>
        @endif
    </div>
</section>
