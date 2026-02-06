<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactRequestMail;
use App\Models\ContactRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        // Get hero for contact page
        $hero = \App\Models\Hero::where('page', 'contact')
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

        return Inertia::render('Frontend/Contact', [
            'services' => $services,
            'hero' => $heroData,
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

        $contactRequest = ContactRequest::create($validated);

        // Load service relationship for email
        $contactRequest->load('service');

        // Send email notification
        Mail::to(config('mail.contact_email', 'info@svsrenov.be'))
            ->send(new ContactRequestMail($contactRequest));

        return redirect()->back()->with('success', 'contact_success');
    }
}
