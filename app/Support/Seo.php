<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Balises SEO d'une page : titre, description, canonical, versions FR/NL, image de partage.
 *
 * Les pages publiques reçoivent des valeurs par défaut selon leur route (voir DEFAULTS) ;
 * un contrôleur peut les remplacer en passant sa propre prop "seo" (ex. article du blog).
 */
class Seo
{
    public const LOCALES = ['fr', 'nl'];

    /** Route => [clé du titre, clé de la description] dans lang/{locale}/messages.php */
    private const DEFAULTS = [
        'home' => ['seo_home_title', 'seo_home_desc'],
        'about.index' => ['seo_about_title', 'seo_about_desc'],
        'services.index' => ['seo_services_title', 'seo_services_desc'],
        'portfolio.index' => ['seo_portfolio_title', 'seo_portfolio_desc'],
        'gallery.index' => ['seo_gallery_title', 'seo_gallery_desc'],
        'blog.index' => ['blog_title', 'blog_subtitle'],
        'contact.index' => ['seo_contact_title', 'seo_contact_desc'],
    ];

    /** Routes qui ne doivent pas apparaître dans Google */
    private const NOINDEX = ['admin.*', 'login', 'password.*', 'verification.*', 'dashboard', 'profile.*'];

    public static function forRequest(Request $request): array
    {
        $route = $request->route()?->getName();
        [$titleKey, $descKey] = self::DEFAULTS[$route] ?? [null, 'seo_home_desc'];

        return self::make(
            title: $titleKey ? __("messages.{$titleKey}") : null,
            description: __("messages.{$descKey}"),
            request: $request,
            noindex: $request->routeIs(...self::NOINDEX),
        );
    }

    public static function make(
        ?string $title,
        ?string $description,
        ?string $image = null,
        string $type = 'website',
        ?Request $request = null,
        bool $noindex = false,
        ?array $jsonLd = null,
    ): array {
        $request ??= request();
        $base = $request->url(); // sans paramètres

        $alternates = [
            'fr' => $base,
            'nl' => $base . '?lang=nl',
        ];

        return [
            'title' => $title,
            'description' => $description ? mb_strimwidth(trim(strip_tags($description)), 0, 170, '…') : null,
            'canonical' => $alternates[app()->getLocale()] ?? $base,
            'alternates' => $alternates,
            'image' => $image ?: asset('image/og-default.jpg'),
            'type' => $type,
            'locale' => app()->getLocale() === 'nl' ? 'nl_BE' : 'fr_BE',
            'noindex' => $noindex,
            'jsonLd' => $jsonLd,
        ];
    }

    /**
     * Fiche entreprise pour Google (données structurées schema.org).
     */
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'HomeAndConstructionBusiness',
            '@id' => url('/') . '#organization',
            'name' => 'SVS RENOV',
            'url' => url('/'),
            'logo' => asset('image/logo.png'),
            'image' => asset('image/og-default.jpg'),
            'description' => __('messages.seo_home_desc'),
            'telephone' => '+32472640679',
            'email' => 'info@svsrenov.be',
            'vatID' => 'BE1011945471',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Vilvoordsesteenweg',
                'postalCode' => '1860',
                'addressLocality' => 'Meise',
                'addressCountry' => 'BE',
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Bruxelles'],
                ['@type' => 'City', 'name' => 'Meise'],
                ['@type' => 'AdministrativeArea', 'name' => 'Brabant flamand'],
            ],
            'sameAs' => [
                'https://www.facebook.com/p/SVS-Renov-61558432052856/',
                'https://www.instagram.com/svsrenov_be/',
            ],
        ];
    }
}
