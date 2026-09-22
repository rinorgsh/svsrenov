{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($urls as $url)
@foreach (['fr' => $url['loc'], 'nl' => $url['loc'] . '?lang=nl'] as $href)
    <url>
        <loc>{{ $href }}</loc>
@if (!empty($url['lastmod']))
        <lastmod>{{ $url['lastmod']->toAtomString() }}</lastmod>
@endif
        <priority>{{ $url['priority'] }}</priority>
        <xhtml:link rel="alternate" hreflang="fr-BE" href="{{ $url['loc'] }}"/>
        <xhtml:link rel="alternate" hreflang="nl-BE" href="{{ $url['loc'] }}?lang=nl"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url['loc'] }}"/>
    </url>
@endforeach
@endforeach
</urlset>
