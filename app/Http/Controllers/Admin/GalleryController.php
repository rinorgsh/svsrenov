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
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file' => 'required_if:type,image|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video_url' => 'required_if:type,video|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ], [
            'gallery_category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type doit être "image" ou "vidéo".',
            'file.required_if' => 'L\'image est obligatoire pour le type "image".',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'L\'image doit être au format : jpeg, png, jpg, gif ou webp.',
            'file.max' => 'L\'image ne doit pas dépasser 10 Mo.',
            'video_url.required_if' => 'L\'URL de la vidéo est obligatoire pour le type "vidéo".',
            'video_url.string' => 'L\'URL de la vidéo doit être du texte.',
            'video_url.max' => 'L\'URL de la vidéo ne doit pas dépasser 500 caractères.',
            'thumbnail.image' => 'La miniature doit être une image.',
            'thumbnail.mimes' => 'La miniature doit être au format : jpeg, png, jpg, gif ou webp.',
            'thumbnail.max' => 'La miniature ne doit pas dépasser 10 Mo.',
            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'is_published.boolean' => 'Le statut de publication doit être vrai ou faux.',
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

        // Retirer les clés 'file' et 'thumbnail' qui ne sont pas des colonnes de la table
        unset($data['file']);
        unset($data['thumbnail']);

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
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video_url' => 'required_if:type,video|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'order' => 'nullable|integer',
            'is_published' => 'boolean',
        ], [
            'gallery_category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type doit être "image" ou "vidéo".',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'L\'image doit être au format : jpeg, png, jpg, gif ou webp.',
            'file.max' => 'L\'image ne doit pas dépasser 10 Mo.',
            'video_url.required_if' => 'L\'URL de la vidéo est obligatoire pour le type "vidéo".',
            'video_url.string' => 'L\'URL de la vidéo doit être du texte.',
            'video_url.max' => 'L\'URL de la vidéo ne doit pas dépasser 500 caractères.',
            'thumbnail.image' => 'La miniature doit être une image.',
            'thumbnail.mimes' => 'La miniature doit être au format : jpeg, png, jpg, gif ou webp.',
            'thumbnail.max' => 'La miniature ne doit pas dépasser 10 Mo.',
            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'is_published.boolean' => 'Le statut de publication doit être vrai ou faux.',
        ]);

        $data = $validated;

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('file')) {
            // Supprimer l'ancienne image
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $data['file_path'] = $request->file('file')->store('gallery/images', 'public');
        }
        // Toujours retirer la clé 'file' qui n'est pas une colonne
        unset($data['file']);

        // Upload de la nouvelle miniature si fournie
        if ($request->hasFile('thumbnail')) {
            // Supprimer l'ancienne miniature
            if ($gallery->thumbnail_path) {
                Storage::disk('public')->delete($gallery->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }
        // Toujours retirer la clé 'thumbnail' qui n'est pas une colonne
        unset($data['thumbnail']);

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
