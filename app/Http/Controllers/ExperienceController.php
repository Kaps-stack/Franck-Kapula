<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceController extends Controller
{
    public function index(): Response
    {
        $experiences = Experience::query()
            ->orderByDesc('start_date')
            ->get();

        return Inertia::render('Experiences/Index', [
            'experiences' => $experiences,
        ]);
    }

    public function show(Experience $experience): Response
    {
        return Inertia::render('Experiences/Show', [
            'experience' => $experience,
        ]);
    }
}
