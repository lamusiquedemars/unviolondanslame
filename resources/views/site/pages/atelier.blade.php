@extends('layouts.site', ['seoTitle' => $page->seo_title ?? "L’atelier | Un violon dans l’âme", 'seoDescription' => $page->seo_description ?? 'Découvrez l’atelier de David, luthier à Décines-Charpieu.'])

@section('content')
    <x-site.hero eyebrow="L’atelier" :title="$page->hero_title ?? 'Un atelier au service de la musique'" :subtitle="$page->hero_subtitle ?? 'Un lieu d’écoute, de travail et de transmission pour les instruments du quatuor.'" :image="$page->heroImageUrl()" :cta-url="$contactUrl" cta-label="Prendre rendez-vous" />
    <x-site.section title="Le geste et l’écoute" container="readable"><div class="prose"><p>Chaque instrument arrive avec son histoire, ses besoins et la musique de la personne qui le joue. David prend le temps d’observer, d’écouter et de proposer l’intervention juste.</p><p>Réglage, entretien, réparation ou restauration : l’atelier accueille violons, altos, violoncelles, contrebasses et archets sur rendez-vous.</p></div></x-site.section>
    <x-site.section variant="surface"><x-site.cta title="Venir à l’atelier" text="Pour un conseil, un essai ou une intervention, prenez contact avec David." :href="$contactUrl" label="Contacter David" inline /></x-site.section>
@endsection
