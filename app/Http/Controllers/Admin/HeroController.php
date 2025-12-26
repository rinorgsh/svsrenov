<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index(): Response
    {
        $heroes = Hero::orderBy('page')->get();

        return Inertia::render('Admin/Hero/Index', [
            'heroes' => $heroes,
        ]);
    }

    public function edit(Hero $hero): Response
    {
        return Inertia::render('Admin/Hero/Edit', [
            'hero' => $hero,
        ]);
    }

    public function update(Request $request, Hero $hero): RedirectResponse
    {
        $validated = $request->validate([
            'page' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'title_fr' => 'nullable|string|max:255',
            'title_nl' => 'nullable|string|max:255',
            'subtitle_fr' => 'nullable|string',
            'subtitle_nl' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format : jpeg, png, jpg, gif ou webp.',
            'image.max' => 'L\'image ne doit pas dépasser 10 Mo.',
            'title_fr.max' => 'Le titre français ne doit pas dépasser 255 caractères.',
            'title_nl.max' => 'Le titre néerlandais ne doit pas dépasser 255 caractères.',
        ]);

        $data = $validated;

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($hero->image_path) {
                Storage::disk('public')->delete($hero->image_path);
            }
            $data['image_path'] = $request->file('image')->store('heroes', 'public');
        } else {
            // Garder l'image existante
            unset($data['image']);
        }

        $hero->update($data);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero modifié avec succès.');
    }
}
