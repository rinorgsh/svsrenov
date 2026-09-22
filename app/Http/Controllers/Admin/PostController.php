<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $posts = Post::orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (Post $post) => [
                'id' => $post->id,
                'slug' => $post->slug,
                'title_fr' => $post->title_fr,
                'has_nl' => filled($post->title_nl) && filled($post->content_nl),
                'cover' => $post->coverUrl(),
                'is_published' => $post->is_published,
                'published_at' => $post->published_at?->format('d/m/Y'),
            ]);

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Form', [
            'post' => null,
            'services' => $this->serviceOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Posts/Form', [
            'post' => [
                ...$post->only([
                    'id', 'slug', 'title_fr', 'title_nl', 'excerpt_fr', 'excerpt_nl',
                    'content_fr', 'content_nl', 'service_id', 'is_published',
                ]),
                'published_at' => $post->published_at?->format('Y-m-d'),
                'cover' => $post->coverUrl(),
            ],
            'services' => $this->serviceOptions(),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        } else {
            unset($data['cover_image']);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article modifié avec succès.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('title_fr')),
        ]);

        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($post?->id)],
            'title_fr' => 'required|string|max:255',
            'title_nl' => 'nullable|string|max:255',
            'excerpt_fr' => 'nullable|string|max:500',
            'excerpt_nl' => 'nullable|string|max:500',
            'content_fr' => 'required|string',
            'content_nl' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'service_id' => 'nullable|exists:services,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Date de publication par défaut : maintenant, au moment de publier
        if ($data['is_published'] ?? false) {
            $data['published_at'] ??= $post?->published_at ?? now();
        }

        return $data;
    }

    private function serviceOptions()
    {
        return Service::orderBy('order')->get(['id', 'title_fr']);
    }
}
