<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller
{
    public function index(): Response
    {
        $educations = Education::query()
            ->orderByDesc('start_date')
            ->get();

        return Inertia::render('Educations/Index', [
            'educations' => $educations,
        ]);
    }

    public function show(Education $education): Response
    {
        return Inertia::render('Educations/Show', [
            'education' => $education,
        ]);
    }
}
