<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ?lang=nl dans l'URL (liens partagés, Google, sélecteur de langue) prime sur la session
        $fromUrl = $request->query('lang');

        if (in_array($fromUrl, ['fr', 'nl'], true)) {
            $request->session()->put('locale', $fromUrl);
        }

        $locale = $request->session()->get('locale', config('app.locale'));

        if (!in_array($locale, ['fr', 'nl'])) {
            $locale = 'fr';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
