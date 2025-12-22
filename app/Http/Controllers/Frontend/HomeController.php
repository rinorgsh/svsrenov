<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Inertia\Inertia;

class HomeController extends Controller
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
                    'icon' => $service->icon,
                    'title' => $service->{"title_{$locale}"},
                    'description' => $service->{"description_{$locale}"},
                    'image' => $service->image,
                ];
            });

        $featuredProjects = Project::where('is_published', true)
            ->where('is_featured', true)
            ->with('service')
            ->orderBy('order')
            ->limit(8)
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
                    ] : null,
                ];
            });

        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('order')
            ->limit(3)
            ->get()
            ->map(function ($testimonial) use ($locale) {
                return [
                    'id' => $testimonial->id,
                    'client_name' => $testimonial->client_name,
                    'client_company' => $testimonial->client_company,
                    'comment' => $testimonial->{"comment_{$locale}"},
                    'rating' => $testimonial->rating,
                    'client_photo' => $testimonial->client_photo ? asset('storage/' . $testimonial->client_photo) : null,
                ];
            });

        return Inertia::render('Frontend/Home', [
            'services' => $services,
            'featuredProjects' => $featuredProjects,
            'testimonials' => $testimonials,
        ]);
    }
}
