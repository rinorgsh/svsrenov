<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($service) use ($locale) {
                return [
                    'id' => $service->id,
                    'slug' => $service->slug,
                    'icon' => $service->icon ?? '🏗️',
                    'title' => $service->{"title_{$locale}"},
                    'description' => $service->{"description_{$locale}"},
                    'long_description' => $service->{"long_description_{$locale}"},
                    'image' => $service->image,
                ];
            });

        return Inertia::render('Frontend/Services', [
            'services' => $services,
        ]);
    }

    public function show($slug)
    {
        $locale = app()->getLocale();

        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $projects = $service->projects()
            ->where('is_published', true)
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
                ];
            });

        return Inertia::render('Frontend/ServiceDetail', [
            'service' => [
                'id' => $service->id,
                'slug' => $service->slug,
                'title' => $service->{"title_{$locale}"},
                'description' => $service->{"description_{$locale}"},
                'long_description' => $service->{"long_description_{$locale}"},
                'image' => $service->image,
            ],
            'projects' => $projects,
        ]);
    }
}
