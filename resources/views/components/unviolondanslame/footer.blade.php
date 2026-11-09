@props(['settings'])
@php($workshop = config('unviolondanslame.workshop'))
<footer class="site-footer container uv-footer">
    <a class="uv-footer__signature" href="{{ route('home') }}">{{ $workshop['name'] }}</a>
    <p>{{ $workshop['owner'] }} · Luthier<br>Décines-Charpieu</p>
    <x-site.social-links :settings="$settings" />
    <p>
        <a href="tel:{{ $workshop['phone_href'] }}">{{ $workshop['phone_display'] }}</a>
        @if ($settings->contact_email)
            <br><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
        @endif
        <br><a href="{{ route('contact') }}">Contact</a>
    </p>
</footer>
