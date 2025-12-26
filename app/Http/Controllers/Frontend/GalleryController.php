<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(): Response
    {
        $locale = app()->getLocale();

        $categories = GalleryCategory::where('is_active', true)
            ->with(['publishedGalleries'])
            ->orderBy('order')
            ->get();

        // Get hero for gallery page
        $hero = \App\Models\Hero::where('page', 'gallery')
            ->where('is_active', true)
            ->first();

        $heroData = null;
        if ($hero) {
            $heroData = [
                'image_url' => $hero->image_path ? asset('storage/' . $hero->image_path) : null,
                'title' => $hero->{"title_{$locale}"},
                'subtitle' => $hero->{"subtitle_{$locale}"},
            ];
        }

        return Inertia::render('Frontend/Gallery/Index', [
            'categories' => $categories,
            'hero' => $heroData,
        ]);
    }
}
