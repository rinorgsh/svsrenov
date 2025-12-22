<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GalleryCategoryController extends Controller
{
    public function index(): Response
    {
        $categories = GalleryCategory::withCount('galleries')
            ->orderBy('order')
            ->get();

        return Inertia::render('Admin/GalleryCategory/Index', [
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/GalleryCategory/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        GalleryCategory::create($validated);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(GalleryCategory $galleryCategory): Response
    {
        return Inertia::render('Admin/GalleryCategory/Edit', [
            'category' => $galleryCategory,
        ]);
    }

    public function update(Request $request, GalleryCategory $galleryCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug,' . $galleryCategory->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $galleryCategory->update($validated);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(GalleryCategory $galleryCategory): RedirectResponse
    {
        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
