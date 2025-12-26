<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Hero;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $projects = Project::where('is_published', true)
            ->with('service')
            ->orderBy('order')
            ->get()
            ->map(function ($project) use ($locale) {
                return [
                    'id' => $project->id,
                    'title' => $project->{"title_{$locale}"},
                    'description' => $project->{"description_{$locale}"},
                    'location' => $project->location,
                    'image_before' => $project->image_before,
                    'image_after' => $project->image_after,
                    'services' => $project->services ?? [],
                    'service' => $project->service ? [
                        'title' => $project->service->{"title_{$locale}"},
                        'slug' => $project->service->slug,
                    ] : null,
                ];
            });

        // Get hero for portfolio page
        $hero = Hero::where('page', 'portfolio')
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

        return Inertia::render('Frontend/Portfolio', [
            'projects' => $projects,
            'hero' => $heroData,
        ]);
    }
}
