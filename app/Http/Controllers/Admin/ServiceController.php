<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('order')->get();

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services,slug|max:255',
            'icon' => 'nullable|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_nl' => 'required|string|max:255',
            'description_fr' => 'required|string',
            'description_nl' => 'required|string',
            'long_description_fr' => 'nullable|string',
            'long_description_nl' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($validated['slug']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/services'), $imageName);
            $validated['image'] = '/image/services/' . $imageName;
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return Inertia::render('Admin/Services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:services,slug,' . $service->id,
            'icon' => 'nullable|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_nl' => 'required|string|max:255',
            'description_fr' => 'required|string',
            'description_nl' => 'required|string',
            'long_description_fr' => 'nullable|string',
            'long_description_nl' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $image = $request->file('image');
            $imageName = Str::slug($validated['slug']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/services'), $imageName);
            $validated['image'] = '/image/services/' . $imageName;
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Delete image if exists
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}
