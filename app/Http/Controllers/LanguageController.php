<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function index(): Response
    {
        $languages = Language::where('featured', true)
            ->get();

        return Inertia::render('Languages/Index', [
            'languages' => $languages,
        ]);
    }
}
