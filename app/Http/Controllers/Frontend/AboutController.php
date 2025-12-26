<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        // Get hero for about page
        $hero = Hero::where('page', 'about')
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

        return Inertia::render('Frontend/About', [
            'hero' => $heroData,
        ]);
    }
}
