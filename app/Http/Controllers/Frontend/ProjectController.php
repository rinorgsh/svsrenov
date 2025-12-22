<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
                    'service' => [
                        'title' => $project->service->{"title_{$locale}"},
                        'slug' => $project->service->slug,
                    ],
                ];
            });

        return Inertia::render('Frontend/Portfolio', [
            'projects' => $projects,
        ]);
    }
}
