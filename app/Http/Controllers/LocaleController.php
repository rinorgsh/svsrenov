<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['fr', 'nl'])) {
            abort(404);
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Redirect back to the previous page
        return redirect()->back();
    }
}
