<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_projects' => Project::count(),
            'published_projects' => Project::where('is_published', true)->count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
            'total_contact_requests' => ContactRequest::count(),
            'unread_contact_requests' => ContactRequest::where('status', 'new')->count(),
        ];

        $recent_projects = Project::with('service')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recent_contact_requests = ContactRequest::with('service')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_projects' => $recent_projects,
            'recent_contact_requests' => $recent_contact_requests,
        ]);
    }
}
