<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(): Response
    {
        $galleries = Gallery::with('category')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = GalleryCategory::orderBy('order')->get();

        return Inertia::render('Admin/Gallery/Index', [
            'galleries' => $galleries,
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('Admin/Gallery/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file' => 'required_if:type,image|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video_url' => 'required_if:type,video|url|nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $data = $validated;

        // Upload de l'image si type = image
        if ($request->type === 'image' && $request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('gallery/images', 'public');
        }

        // Upload de la miniature pour les vidéos
        if ($request->type === 'video' && $request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Élément ajouté à la galerie avec succès.');
    }

    public function edit(Gallery $gallery): Response
    {
        $gallery->load('category');

        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('Admin/Gallery/Edit', [
            'gallery' => $gallery,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video_url' => 'required_if:type,video|url|nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $data = $validated;

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('file')) {
            // Supprimer l'ancienne image
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $data['file_path'] = $request->file('file')->store('gallery/images', 'public');
        } else {
            // Garder l'image existante
            unset($data['file']);
        }

        // Upload de la nouvelle miniature si fournie
        if ($request->hasFile('thumbnail')) {
            // Supprimer l'ancienne miniature
            if ($gallery->thumbnail_path) {
                Storage::disk('public')->delete($gallery->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        } else {
            // Garder la miniature existante
            unset($data['thumbnail']);
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Élément modifié avec succès.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        // Supprimer les fichiers associés
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        if ($gallery->thumbnail_path) {
            Storage::disk('public')->delete($gallery->thumbnail_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Élément supprimé de la galerie avec succès.');
    }
}
