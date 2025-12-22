<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
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
                    'title' => $service->{"title_{$locale}"},
                ];
            });

        return Inertia::render('Frontend/Contact', [
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'service_id' => 'nullable|exists:services,id',
            'message' => 'required|string',
        ]);

        ContactRequest::create($validated);

        return redirect()->back()->with('success', 'contact_success');
    }
}
