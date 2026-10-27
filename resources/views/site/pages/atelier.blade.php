@extends('layouts.site', [
    'seoTitle' => $page->seo_title ?? 'L’atelier de David Gellé | Luthier à Décines-Charpieu',
    'seoDescription' => $page->seo_description ?? 'Découvrez l’atelier de David Gellé, luthier à Décines-Charpieu, son parcours et son travail sur les instruments du quatuor.',
    'seoImage' => $page->heroImageUrl(),
])

@section('content')
    @php
        $working = $atelierMedia->get('working');
        $samvel = $atelierMedia->get('samvel');
        $bench = $atelierMedia->get('bench');
    @endphp

    <x-site.hero
        class="uv-atelier-hero"
        eyebrow="L’atelier · Décines-Charpieu"
        :title="$page->hero_title ?? 'Un atelier au service de la musique'"
        :subtitle="$page->hero_subtitle ?? 'Je suis David Gellé, luthier à Décines-Charpieu. Dans mon atelier, je prends soin des instruments du quatuor et des archets.'"
        :image="$page->heroImageUrl()"
        :image-sources="$page->heroImageSources()"
        :cta-url="$contactUrl"
        cta-label="Prendre rendez-vous"
        secondary-cta-url="#parcours"
        secondary-cta-label="Découvrir mon parcours"
    />

    <x-site.section title="Le geste et l’écoute">
        <div class="uv-atelier-split">
            @if ($working)
                <figure class="uv-atelier-photo">
                    <x-site.image
                        :src="$working->url()"
                        :srcset="$working->srcset()"
                        sizes="(max-width: 700px) 100vw, 42vw"
                        alt="David Gellé travaillant sur un violoncelle à l’atelier"
                        :width="$working->width"
                        :height="$working->height"
                    />
                </figure>
            @endif

            <div class="prose uv-atelier-copy">
                <p>Chaque instrument possède son histoire, ses particularités et ses qualités musicales. Dans mon travail, j’accorde autant d’importance à son observation qu’à l’échange avec la personne qui le joue.</p>
                <p>J’accueille des élèves d’écoles de musique et de conservatoires, leurs familles, des professeurs et des musiciens professionnels. Chacun vient avec des attentes différentes : entretenir un instrument, résoudre un problème, améliorer un réglage ou envisager une restauration.</p>
                <p>Mon rôle est de comprendre ces besoins et de proposer un travail adapté à l’instrument et à son utilisation.</p>
            </div>
        </div>
    </x-site.section>

    <x-site.section id="parcours" variant="surface" title="Un parcours d’apprentissage et de pratique">
        <div class="uv-atelier-split uv-atelier-split--reverse">
            <div class="prose uv-atelier-copy">
                <p>Mon parcours en lutherie a commencé par un apprentissage personnel, avant de se poursuivre directement auprès de Samvel Yeritsyan, maître luthier à Erevan, en Arménie.</p>
                <p>Cette formation auprès de ce grand maître m’a permis d’approfondir ma connaissance du métier au contact des instruments et du travail quotidien de l’atelier.</p>
                <p>Aujourd’hui, je poursuis ce travail dans mon propre atelier à Décines-Charpieu, où je me consacre à l’entretien, au réglage, à la réparation et à la restauration des instruments.</p>
            </div>

            @if ($samvel)
                <figure class="uv-atelier-photo">
                    <x-site.image
                        :src="$samvel->url()"
                        :srcset="$samvel->srcset()"
                        sizes="(max-width: 700px) 100vw, 42vw"
                        alt="David Gellé avec Samvel Yeritsyan, maître luthier, à Erevan"
                        :width="$samvel->width"
                        :height="$samvel->height"
                    />
                </figure>
            @endif
        </div>
    </x-site.section>

    <x-site.section title="Une attention à chaque instrument">
        <div class="uv-atelier-split">
            @if ($bench)
                <figure class="uv-atelier-photo uv-atelier-photo--bench">
                    <x-site.image
                        :src="$bench->url()"
                        :srcset="$bench->srcset()"
                        sizes="(max-width: 700px) 100vw, 42vw"
                        alt="Établi de luthier et outils de travail à l’atelier"
                        :width="$bench->width"
                        :height="$bench->height"
                    />
                </figure>
            @endif

            <div class="prose uv-atelier-copy">
                <p>Avant d’entreprendre une intervention, je prends en compte l’état de l’instrument, ses particularités et les attentes du musicien.</p>
                <p>J’examine sa construction et les éléments qui peuvent nécessiter un entretien, un réglage ou une réparation. Je prends aussi le temps d’échanger avec vous sur votre pratique et les difficultés rencontrées.</p>
                <p>Du réglage courant à la restauration plus approfondie, je réalise les travaux adaptés à l’instrument et à ses particularités.</p>
            </div>
        </div>
    </x-site.section>

    <x-site.section variant="surface">
        <x-site.cta
            title="Je vous accueille à Décines-Charpieu"
            text="Vous souhaitez me confier un instrument, me demander un conseil ou organiser un essai ? Écrivez-moi pour que nous convenions d’un rendez-vous à l’atelier."
            :href="$contactUrl"
            label="Prendre rendez-vous"
            inline
        />
    </x-site.section>
@endsection
