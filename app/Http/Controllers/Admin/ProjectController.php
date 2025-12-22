<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        // Create directory for this project
        $projectSlug = Str::slug($validated['title_fr']);
        $projectDir = public_path('image/projects/' . $projectSlug);

        if (!file_exists($projectDir)) {
            mkdir($projectDir, 0755, true);
        }

        // Handle image_before upload
        if ($request->hasFile('image_before')) {
            $image = $request->file('image_before');
            $imageName = 'before.' . $image->getClientOriginalExtension();
            $image->move($projectDir, $imageName);
            $validated['image_before'] = '/image/projects/' . $projectSlug . '/' . $imageName;
        }

        // Handle image_after upload
        if ($request->hasFile('image_after')) {
            $image = $request->file('image_after');
            $imageName = 'after.' . $image->getClientOriginalExtension();
            $image->move($projectDir, $imageName);
            $validated['image_after'] = '/image/projects/' . $projectSlug . '/' . $imageName;
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

        // Create directory for this project
        $projectSlug = Str::slug($validated['title_fr']);
        $projectDir = public_path('image/projects/' . $projectSlug);

        if (!file_exists($projectDir)) {
            mkdir($projectDir, 0755, true);
        }

        // Handle image_before upload
        if ($request->hasFile('image_before')) {
            // Delete old image if exists
            if ($project->image_before && file_exists(public_path($project->image_before))) {
                unlink(public_path($project->image_before));
            }

            $image = $request->file('image_before');
            $imageName = 'before.' . $image->getClientOriginalExtension();
            $image->move($projectDir, $imageName);
            $validated['image_before'] = '/image/projects/' . $projectSlug . '/' . $imageName;
        } else {
            // Keep existing image - don't update this field
            unset($validated['image_before']);
        }

        // Handle image_after upload
        if ($request->hasFile('image_after')) {
            // Delete old image if exists
            if ($project->image_after && file_exists(public_path($project->image_after))) {
                unlink(public_path($project->image_after));
            }

            $image = $request->file('image_after');
            $imageName = 'after.' . $image->getClientOriginalExtension();
            $image->move($projectDir, $imageName);
            $validated['image_after'] = '/image/projects/' . $projectSlug . '/' . $imageName;
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
        if ($project->image_before && file_exists(public_path($project->image_before))) {
            unlink(public_path($project->image_before));
        }
        if ($project->image_after && file_exists(public_path($project->image_after))) {
            unlink(public_path($project->image_after));
        }

        // Try to delete the project directory if it's empty
        if ($project->image_before) {
            $projectDir = dirname(public_path($project->image_before));
            if (file_exists($projectDir) && count(scandir($projectDir)) == 2) { // only . and ..
                rmdir($projectDir);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }
}
