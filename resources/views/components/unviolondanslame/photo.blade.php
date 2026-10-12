@props(['name', 'priority' => false, 'sizes' => '(max-width: 800px) 100vw, 50vw'])
@php($photo = config('unviolondanslame.photos.'.$name, []))
<figure {{ $attributes->class(['uv-photo', 'uv-photo--placeholder' => empty($photo['src'])]) }}>
    @if (! empty($photo['src']))
        <img src="{{ $photo['src'] }}"
            @if (! empty($photo['srcset'])) srcset="{{ $photo['srcset'] }}" sizes="{{ $sizes }}" @endif
            alt="{{ $photo['alt'] }}" width="1200" height="900"
            loading="{{ $priority ? 'eager' : 'lazy' }}"
            fetchpriority="{{ $priority ? 'high' : 'auto' }}" decoding="async">
    @else
        <div class="uv-photo__placeholder">
            <span class="uv-photo__line" aria-hidden="true"></span>
            <span class="uv-photo__label">{{ $photo['label'] ?? 'L’atelier' }}</span>
            <span class="uv-photo__note">Photographie à venir</span>
        </div>
    @endif
</figure>
