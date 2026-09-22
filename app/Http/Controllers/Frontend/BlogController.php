<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\Seo;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()
            ->get()
            ->map(fn (Post $post) => $post->toCard());

        return Inertia::render('Frontend/Blog/Index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug): Response
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('service')
            ->firstOrFail();

        $locale = app()->getLocale();

        // Contenu rédigé en Markdown dans l'admin ; le HTML brut est retiré
        $html = Str::markdown($post->localized('content') ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get()
            ->map(fn (Post $p) => $p->toCard());

        return Inertia::render('Frontend/Blog/Show', [
            'post' => [
                ...$post->toCard(),
                'html' => $html,
                'url' => route('blog.show', $post->slug),
                'updated_at' => $post->updated_at?->toIso8601String(),
                'service' => $post->service ? [
                    'title' => $post->service->{"title_{$locale}"},
                    'slug' => $post->service->slug,
                ] : null,
            ],
            'related' => $related,
            'seo' => Seo::make(
                title: $post->localized('title'),
                description: $post->summary(),
                image: $post->coverUrl(),
                type: 'article',
                jsonLd: [
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'headline' => $post->localized('title'),
                    'description' => $post->summary(),
                    'image' => $post->coverUrl() ?: asset('image/og-default.jpg'),
                    'datePublished' => $post->published_at?->toIso8601String(),
                    'dateModified' => $post->updated_at?->toIso8601String(),
                    'inLanguage' => $locale === 'nl' ? 'nl-BE' : 'fr-BE',
                    'mainEntityOfPage' => route('blog.show', $post->slug),
                    'author' => ['@id' => url('/') . '#organization'],
                    'publisher' => ['@id' => url('/') . '#organization'],
                ],
            ),
        ]);
    }
}
