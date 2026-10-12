@extends('layouts.site', [
    'brandName' => "Un violon dans l'âme",
    'seoTitle' => "Luthier à Décines-Charpieu | Un violon dans l'âme",
    'seoDescription' => 'Atelier de lutherie à Décines-Charpieu : réparation, restauration, réglage, entretien, vente et location de violons, altos, violoncelles et contrebasses.',
    'seoImage' => config('unviolondanslame.photos.hero.src'),
])

@section('site-header')
    <a class="uv-skip" href="#contenu">Aller au contenu</a>
    <header class="site-header container uv-header" data-nav>
        <a class="site-brand" href="{{ route('home') }}" aria-label="Un violon dans l’âme — Accueil">
            <span><strong>Un violon dans l'âme</strong><small>Atelier de lutherie</small></span>
        </a>
        <button class="btn btn--secondary nav-toggle" data-nav-toggle type="button" aria-controls="navigation-atelier" aria-expanded="false">Menu</button>
        <nav class="site-nav" id="navigation-atelier" data-nav-menu aria-label="Navigation principale">
            <a href="{{ route('home') }}" aria-current="page">Accueil</a>
            <a href="{{ $servicesUrl ?? '#services' }}">Services de lutherie</a>
            <a href="#instruments">Instruments</a>
            <a href="#atelier">L'atelier</a>
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
                <p class="uv-hero__description">Réparation, restauration, réglage et entretien des instruments du quatuor. Vente et location de violons, altos, violoncelles et contrebasses, dans un atelier qui vous accueille sur rendez-vous.</p>
                <div class="cluster uv-actions">
                    <x-site.button :href="$contactUrl">Prendre rendez-vous</x-site.button>
                    <x-site.button :href="$servicesUrl ?? '#services'" variant="secondary">Découvrir les services</x-site.button>
                </div>
            </div>
            <x-unviolondanslame.photo name="hero" priority class="uv-hero__photo" />
        </div>
    </section>

    <x-site.section class="uv-paths" aria-label="Votre besoin">
        <x-site.grid columns="3">
            <article class="uv-path" id="services">
                <x-unviolondanslame.photo name="services" sizes="(max-width: 700px) 100vw, 33vw" />
                <div class="uv-path__body">
                    <h2>Réparer ou régler</h2>
                    <p>Un problème de sonorité, un instrument abîmé ou un archet à remécher ?</p>
                    <a class="uv-text-link" href="{{ $servicesUrl ?? $contactUrl }}">Voir les services <span aria-hidden="true">↗</span></a>
                </div>
            </article>
            <article class="uv-path" id="instruments">
                <x-unviolondanslame.photo name="instruments" sizes="(max-width: 700px) 100vw, 33vw" />
                <div class="uv-path__body">
                    <h2>Louer ou acheter</h2>
                    <p>Pour débuter, poursuivre son apprentissage ou trouver un nouvel instrument.</p>
                    <button class="uv-text-link uv-text-link--pending" type="button" disabled aria-describedby="instruments-attente">Voir les instruments <span aria-hidden="true">↗</span></button>
                    <small class="uv-pending" id="instruments-attente">Sélection à venir. <a href="{{ $contactUrl }}">Contacter David pour un essai.</a></small>
                </div>
            </article>
            <article class="uv-path">
                <x-unviolondanslame.photo name="atelier" sizes="(max-width: 700px) 100vw, 33vw" />
                <div class="uv-path__body">
                    <h2>Découvrir l'atelier</h2>
                    <p>Faites connaissance avec David, son parcours et son travail de luthier.</p>
                    <a class="uv-text-link" href="#atelier">Découvrir l'atelier <span aria-hidden="true">↗</span></a>
                </div>
            </article>
        </x-site.grid>
    </x-site.section>

    <x-site.section class="uv-work" id="atelier" aria-labelledby="atelier-titre">
        <div class="split">
            <x-unviolondanslame.photo name="travail" />
            <div class="uv-work__text">
                <h2 id="atelier-titre">Le soin apporté<br> à chaque instrument</h2>
                <p>Chaque instrument possède ses particularités. Son entretien et sa réparation demandent une attention à son état, à sa sonorité et à son confort de jeu.</p>
                <p>Du réglage à la restauration, David réalise les interventions nécessaires sur les instruments du quatuor et les archets.</p>
                <p class="uv-work__aside">Son expérience comprend également des interventions sur certains instruments traditionnels, notamment le kamantcha et l'oud.</p>
                <x-site.button variant="secondary" disabled aria-describedby="atelier-attente">Découvrir l'atelier</x-site.button>
                <small class="uv-pending" id="atelier-attente">La page de l’atelier sera disponible prochainement.</small>
            </div>
        </div>
    </x-site.section>

    <x-site.section class="uv-contact" aria-labelledby="contact-titre">
        <div class="uv-contact__inner">
            <h2 id="contact-titre">Parlons de votre instrument</h2>
            <p>Besoin d'un réglage, d'une réparation ou d'un instrument à essayer ? David vous accueille à Décines-Charpieu sur rendez-vous.</p>
            <p>Vous pouvez le contacter pour présenter votre besoin ou envoyer des photos de votre instrument.</p>
            <div class="cluster cluster--center uv-actions">
                <x-site.button :href="$contactUrl">Prendre rendez-vous</x-site.button>
                <x-site.button :href="$contactUrl" variant="secondary" aria-describedby="photos-attente">Envoyer des photos</x-site.button>
            </div>
            <p class="uv-pending" id="photos-attente">L’ajout de photos au formulaire sera disponible prochainement. Contactez David pour convenir de leur envoi.</p>
        </div>
    </x-site.section>
@endsection

@section('site-footer')
    <footer class="site-footer container uv-footer">
        <a class="uv-footer__signature" href="{{ route('home') }}">Un violon dans l'âme</a>
        <p>Atelier de lutherie · Décines-Charpieu<br>Accueil sur rendez-vous</p>
        <p class="uv-footer__copyright">© {{ now()->year }} Un violon dans l'âme</p>
    </footer>
@endsection
