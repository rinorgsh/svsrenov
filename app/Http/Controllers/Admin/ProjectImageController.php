<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'caption_fr' => 'nullable|string|max:255',
            'caption_nl' => 'nullable|string|max:255',
        ]);

        $projectSlug = Str::slug($project->title_fr);
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = 'gallery-' . Str::random(10) . '.' . $extension;

        $path = $file->storeAs('projects/' . $projectSlug, $filename, 'public');

        $maxOrder = $project->images()->max('order') ?? 0;

        $image = $project->images()->create([
            'path' => '/storage/' . $path,
            'caption_fr' => $validated['caption_fr'] ?? null,
            'caption_nl' => $validated['caption_nl'] ?? null,
            'order' => $maxOrder + 1,
        ]);

        return response()->json(['image' => $image]);
    }

    public function update(Request $request, Project $project, ProjectImage $image)
    {
        abort_unless($image->project_id === $project->id, 404);

        $validated = $request->validate([
            'caption_fr' => 'nullable|string|max:255',
            'caption_nl' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return response()->json(['image' => $image]);
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_unless($image->project_id === $project->id, 404);

        $path = str_replace('/storage/', '', $image->path);
        Storage::disk('public')->delete($path);

        $image->delete();

        return response()->json(['ok' => true]);
    }

    public function reorder(Request $request, Project $project)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:project_images,id',
        ]);

        foreach ($validated['ids'] as $index => $id) {
            ProjectImage::where('id', $id)
                ->where('project_id', $project->id)
                ->update(['order' => $index + 1]);
        }

        return response()->json(['ok' => true]);
    }
}
