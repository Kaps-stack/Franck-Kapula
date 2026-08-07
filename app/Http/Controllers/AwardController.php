<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Inertia\Inertia;
use Inertia\Response;

class AwardController extends Controller
{
    public function index(): Response
    {
        $awards = Award::query()
            ->orderByDesc('date')
            ->get();

        return Inertia::render('Awards/Index', [
            'awards' => $awards,
        ]);
    }

    public function show(Award $award): Response
    {
        return Inertia::render('Awards/Show', [
            'award' => $award,
        ]);
    }
}
