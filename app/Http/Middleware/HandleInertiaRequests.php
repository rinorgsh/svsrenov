<?php

namespace App\Http\Middleware;

use App\Support\Seo;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale' => app()->getLocale(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
            // Valeurs SEO par défaut de la route ; un contrôleur peut passer sa propre prop "seo"
            'seo' => fn () => Seo::forRequest($request),
            'translations' => function () {
                $locale = app()->getLocale();
                $langPath = lang_path("{$locale}/messages.php");

                if (file_exists($langPath)) {
                    return require $langPath;
                }

                return [];
            },
        ];
    }
}
