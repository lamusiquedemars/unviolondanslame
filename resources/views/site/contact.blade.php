@extends('layouts.site', [
    'seoTitle' => $page?->seo_title ?? ('Contact - ' . $settings->site_name),
    'seoDescription' => $page?->seo_description ?? 'Prendre rendez-vous avec David Gellé, luthier à Décines-Charpieu.',
    'seoImage' => $page?->heroImageUrl(),
])

@section('content')
    @php($workshop = config('unviolondanslame.workshop'))
    @php($portrait = $page?->heroMedia)

    <x-site.section class="uv-contact-page" aria-labelledby="contact-title">
        <div class="uv-contact-page__intro">
            <p class="eyebrow">L’atelier</p>
            <h1 id="contact-title">Parlons de votre instrument</h1>
            <p>Vous souhaitez faire réparer ou régler un instrument, demander un renseignement, organiser un essai ou une location ? Écrivez-moi pour me présenter votre besoin. Je vous répondrai afin que nous convenions d’un rendez-vous à l’atelier.</p>
        </div>

        <div class="uv-contact-page__grid">
            <aside class="uv-contact-details" aria-label="Coordonnées de l’atelier">
                @if ($portrait)
                    <figure class="uv-photo uv-contact-details__portrait">
                        <x-site.image
                            :src="$portrait->url()"
                            :srcset="$portrait->srcset()"
                            sizes="(max-width: 760px) min(100vw - 40px, 360px), 30vw"
                            :alt="$portrait->alt_text ?: 'David Gellé, luthier à son atelier'"
                            :width="$portrait->width"
                            :height="$portrait->height"
                        />
                    </figure>
                @else
                    <x-unviolondanslame.photo name="david" class="uv-contact-details__portrait" />
                @endif
                <h2>{{ $workshop['name'] }}</h2>
                <p>{{ $workshop['owner'] }}, luthier<br>{{ $workshop['address_lines'][0] }}<br>{{ $workshop['address_lines'][1] }}</p>
                <p><a href="tel:{{ $workshop['phone_href'] }}">{{ $workshop['phone_display'] }}</a></p>
                <p class="uv-contact-details__appointment">Accueil uniquement sur rendez-vous.</p>
            </aside>

            <div>
                @if (session('status'))
                    <p class="notice">{{ session('status') }}</p>
                @endif

                <form method="post" action="{{ route('contact.store') }}" class="form-grid uv-contact-form" data-form>
            @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;">

                    <label class="field">
                    Nom
                    <input name="name" value="{{ old('name') }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                    </label>

                    <label class="field">
                Email
                <input name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <small>{{ $message }}</small> @enderror
                    </label>

                    <label class="field">
                    Téléphone
                    <input name="phone" value="{{ old('phone') }}">
                    </label>

                    <label class="field">
                    Sujet
                        <select name="subject" required>
                            <option value="" disabled @selected(! old('subject'))>Choisir un sujet</option>
                            <option value="repair" @selected(old('subject') === 'repair')>Réparation</option>
                            <option value="adjustment" @selected(old('subject') === 'adjustment')>Réglage</option>
                            <option value="restoration" @selected(old('subject') === 'restoration')>Restauration</option>
                            <option value="purchase_or_trial" @selected(old('subject') === 'purchase_or_trial')>Achat ou essai</option>
                            <option value="rental" @selected(old('subject') === 'rental')>Location</option>
                            <option value="other" @selected(old('subject') === 'other')>Autre</option>
                        </select>
                        @error('subject') <small>{{ $message }}</small> @enderror
                    </label>

                    <label class="field full">
                Message
                <textarea name="message" rows="7" required>{{ old('message') }}</textarea>
                @error('message') <small>{{ $message }}</small> @enderror
                    </label>
                    <div class="full">
                        <x-site.button type="submit">Envoyer le message</x-site.button>
                    </div>
                </form>
            </div>
        </div>
    </x-site.section>

    <x-site.section class="uv-directions" variant="surface" aria-labelledby="directions-title">
        <div class="uv-directions__inner">
            <div>
                <p class="eyebrow">Se rendre à l’atelier</p>
                <h2 id="directions-title">Venir à l’atelier</h2>
                <p>13 rue Hector Berlioz, 69150 Décines-Charpieu.</p>
            </div>
            <div class="uv-directions__details">
                <p><strong>En transports en commun</strong><br>Tramway T3 : arrêt Décines Centre, environ 10 minutes à pied.<br>Bus 67 : arrêt Coli, environ 4 minutes à pied.</p>
                <p><strong>En voiture</strong><br>Utilisez l’itinéraire pour rejoindre directement l’adresse.</p>
                <x-site.button :href="$workshop['directions_url']" target="_blank" rel="noopener">Calculer mon itinéraire</x-site.button>
            </div>
        </div>
    </x-site.section>
@endsection
