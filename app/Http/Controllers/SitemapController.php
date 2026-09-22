<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * sitemap.xml : toutes les pages publiques, avec leur version néerlandaise (?lang=nl).
     */
    public function sitemap(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('services.index'), 'priority' => '0.9'],
            ['loc' => route('portfolio.index'), 'priority' => '0.8'],
            ['loc' => route('blog.index'), 'priority' => '0.8'],
            ['loc' => route('about.index'), 'priority' => '0.6'],
            ['loc' => route('gallery.index'), 'priority' => '0.6'],
            ['loc' => route('contact.index'), 'priority' => '0.7'],
        ]);

        Service::where('is_active', true)->orderBy('order')->get()
            ->each(fn (Service $s) => $urls->push([
                'loc' => route('services.show', $s->slug),
                'lastmod' => $s->updated_at,
                'priority' => '0.8',
            ]));

        Post::published()->get()
            ->each(fn (Post $p) => $urls->push([
                'loc' => route('blog.show', $p->slug),
                'lastmod' => $p->updated_at,
                'priority' => '0.7',
            ]));

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /login',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /dashboard',
            'Disallow: /profile',
            '',
            'Sitemap: ' . route('sitemap'),
        ];

        return response(implode("\n", $lines) . "\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
