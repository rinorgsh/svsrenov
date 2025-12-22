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
        $categories = GalleryCategory::where('is_active', true)
            ->with(['publishedGalleries'])
            ->orderBy('order')
            ->get();

        return Inertia::render('Frontend/Gallery/Index', [
            'categories' => $categories,
        ]);
    }
}
