<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('service')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'title_fr', 'title_nl']);

        return Inertia::render('Admin/Projects/Create', [
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'services' => 'nullable|array',
            'services.*' => 'string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_nl' => 'required|string|max:255',
            'description_fr' => 'required|string',
            'description_nl' => 'required|string',
            'location' => 'required|string|max:255',
            'image_before' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_after' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image_before upload
        if ($request->hasFile('image_before')) {
            $projectSlug = Str::slug($validated['title_fr']);
            $image = $request->file('image_before');
            $extension = $image->getClientOriginalExtension();
            $path = $image->storeAs('projects/' . $projectSlug, 'before.' . $extension, 'public');
            $validated['image_before'] = '/storage/' . $path;
        }

        // Handle image_after upload
        if ($request->hasFile('image_after')) {
            $projectSlug = Str::slug($validated['title_fr']);
            $image = $request->file('image_after');
            $extension = $image->getClientOriginalExtension();
            $path = $image->storeAs('projects/' . $projectSlug, 'after.' . $extension, 'public');
            $validated['image_after'] = '/storage/' . $path;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return redirect()->route('admin.projects.edit', $project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'title_fr', 'title_nl']);

        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project->load('service'),
            'services' => $services,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'services' => 'nullable|array',
            'services.*' => 'string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_nl' => 'required|string|max:255',
            'description_fr' => 'required|string',
            'description_nl' => 'required|string',
            'location' => 'required|string|max:255',
            'image_before' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_after' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image_before upload
        if ($request->hasFile('image_before')) {
            // Delete old image if exists
            if ($project->image_before) {
                $oldPath = str_replace('/storage/', '', $project->image_before);
                Storage::disk('public')->delete($oldPath);
            }

            $projectSlug = Str::slug($validated['title_fr']);
            $image = $request->file('image_before');
            $extension = $image->getClientOriginalExtension();
            $path = $image->storeAs('projects/' . $projectSlug, 'before.' . $extension, 'public');
            $validated['image_before'] = '/storage/' . $path;
        } else {
            // Keep existing image - don't update this field
            unset($validated['image_before']);
        }

        // Handle image_after upload
        if ($request->hasFile('image_after')) {
            // Delete old image if exists
            if ($project->image_after) {
                $oldPath = str_replace('/storage/', '', $project->image_after);
                Storage::disk('public')->delete($oldPath);
            }

            $projectSlug = Str::slug($validated['title_fr']);
            $image = $request->file('image_after');
            $extension = $image->getClientOriginalExtension();
            $path = $image->storeAs('projects/' . $projectSlug, 'after.' . $extension, 'public');
            $validated['image_after'] = '/storage/' . $path;
        } else {
            // Keep existing image - don't update this field
            unset($validated['image_after']);
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Delete images if they exist
        if ($project->image_before) {
            $path = str_replace('/storage/', '', $project->image_before);
            Storage::disk('public')->delete($path);
        }
        if ($project->image_after) {
            $path = str_replace('/storage/', '', $project->image_after);
            Storage::disk('public')->delete($path);
        }

        // Try to delete the project directory if it's empty
        if ($project->image_before) {
            $projectSlug = Str::slug($project->title_fr);
            $projectDir = 'projects/' . $projectSlug;
            if (Storage::disk('public')->exists($projectDir)) {
                $files = Storage::disk('public')->files($projectDir);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($projectDir);
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }
}
