@extends('layouts.site', [
    'seoTitle' => $page->seo_title ?? "Services de lutherie | Un violon dans l’âme",
    'seoDescription' => $page->seo_description ?? 'Réparation, restauration, réglage et entretien des instruments du quatuor à Décines-Charpieu.',
    'seoImage' => $page->heroImageUrl(),
])

@section('content')
    <x-site.hero
        class="uv-services-hero"
        eyebrow="Services de lutherie"
        :title="$page->hero_title ?? 'Prendre soin de votre instrument'"
        :subtitle="$page->hero_subtitle ?? 'Je réalise les travaux de réglage, d’entretien, de réparation et de restauration des violons, altos, violoncelles et contrebasses, ainsi que le reméchage des archets. Je vous accueille sur rendez-vous à mon atelier de Décines-Charpieu.'"
        :image="$page->heroImageUrl()"
        :image-sources="$page->heroImageSources()"
        :cta-url="$contactUrl"
        cta-label="Demander un avis"
        secondary-cta-url="#prestations"
        secondary-cta-label="Découvrir les prestations"
    />

    <x-site.section id="prestations" title="À l’atelier" intro="Un problème de sonorité, un instrument abîmé, une restauration à envisager ? J’interviens aussi bien pour l’entretien courant que pour des travaux de lutherie plus approfondis. J’ai également eu l’occasion de réparer certains instruments traditionnels, notamment des kamantchas et des ouds.">
        <x-site.grid columns="3" class="uv-service-grid">
            <article class="card uv-service-card">
                <p class="card__kicker">Au quotidien</p>
                <h3>Réglage et entretien</h3>
                <p>Pour retrouver une bonne réponse et un jeu confortable, j’interviens sur les éléments qui influencent la sonorité et le confort de votre instrument.</p>
                <ul>
                    <li>Réglage de sonorité</li>
                    <li>Âme, chevalet, cheville, touche et sillets</li>
                    <li>Entretien général</li>
                </ul>
            </article>

            <article class="card uv-service-card">
                <p class="card__kicker">Avec attention</p>
                <h3>Réparation et restauration</h3>
                <p>J’examine l’état et l’histoire de votre instrument afin d’envisager une intervention adaptée, d’une réparation ponctuelle à des travaux plus approfondis.</p>
                <ul>
                    <li>Fissures, fractures et réparations de structure</li>
                    <li>Manche et correction du renversement</li>
                    <li>Retouches de vernis et travaux de restauration</li>
                </ul>
            </article>

            <article class="card uv-service-card">
                <p class="card__kicker">Archets</p>
                <h3>Reméchage</h3>
                <p>Je réalise le reméchage des archets de violon, d’alto, de violoncelle et de contrebasse.</p>
            </article>
        </x-site.grid>

    </x-site.section>

    @if ($restorationGalleries->isNotEmpty())
        <x-site.section variant="surface" title="Quelques travaux réalisés à l’atelier" intro="Voici quelques exemples de restaurations que j’ai réalisées. Ces photographies permettent de découvrir les instruments, les interventions et différentes étapes de mon travail.">
            <div class="uv-restoration-grid">
                @foreach ($restorationGalleries as $gallery)
                    @php
                        $images = $gallery->images;
                        $cover = $images->first();
                    @endphp
                    <article class="uv-restoration-card" data-lightbox>
                        <a
                            class="uv-restoration-card__cover"
                            href="{{ $cover->resolved_image_url }}"
                            data-pswp-width="{{ $cover->width ?? 1600 }}"
                            data-pswp-height="{{ $cover->height ?? 1000 }}"
                            aria-label="Voir la restauration : {{ $gallery->title }}"
                        >
                            <x-site.image
                                :src="$cover->resolved_image_url"
                                :alt="$cover->alt ?: $gallery->title"
                                :width="$cover->width"
                                :height="$cover->height"
                                :srcset="$cover->media?->srcset()"
                                sizes="(max-width: 700px) calc(100vw - 40px), 360px"
                            />
                            <span class="uv-restoration-card__action">Voir la restauration <span aria-hidden="true">→</span></span>
                        </a>
                        @foreach ($images->skip(1) as $image)
                            <a
                                href="{{ $image->resolved_image_url }}"
                                data-pswp-width="{{ $image->width ?? 1600 }}"
                                data-pswp-height="{{ $image->height ?? 1000 }}"
                                hidden
                                aria-hidden="true"
                                tabindex="-1"
                            ></a>
                        @endforeach
                        <div class="uv-restoration-card__content">
                            <p class="eyebrow">Restauration</p>
                            <h3>{{ $gallery->title }}</h3>
                            @if ($gallery->intro)<p>{{ $gallery->intro }}</p>@endif
                        </div>
                    </article>
                @endforeach
            </div>
        </x-site.section>
    @endif

    <x-site.section title="De votre demande à l’atelier" intro="Chaque intervention commence par un échange et l’examen de votre instrument.">
        <x-site.grid columns="3" class="uv-service-steps">
            <article class="card card--ghost"><p class="card__kicker">01</p><h3>Vous m’expliquez votre besoin</h3><p>Vous pouvez me contacter pour décrire le problème rencontré ou le travail souhaité.</p></article>
            <article class="card card--ghost"><p class="card__kicker">02</p><h3>J’examine votre instrument</h3><p>Nous convenons d’un rendez-vous à l’atelier pour que je puisse examiner son état et discuter des interventions envisageables.</p></article>
            <article class="card card--ghost"><p class="card__kicker">03</p><h3>Nous définissons la suite</h3><p>Je vous explique les travaux proposés et nous convenons ensemble des suites à donner avant toute intervention.</p></article>
        </x-site.grid>
    </x-site.section>

    <x-site.section variant="surface"><x-site.cta title="Parlons de votre instrument" text="Besoin d’un réglage, d’une réparation ou d’un avis sur une restauration ? Je vous accueille sur rendez-vous à mon atelier de Décines-Charpieu." :href="$contactUrl" label="Prendre rendez-vous" inline /></x-site.section>
@endsection
