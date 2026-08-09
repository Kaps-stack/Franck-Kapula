<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Interest;
use App\Models\Language;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $profile = Profile::first();

        $projects = Project::latest()
            ->take(3)
            ->get();

        $experiences = Experience::latest()
            ->take(2)
            ->get();

        $education = Education::latest()
            ->take(2)
            ->get();

        $interests = Interest::query()
            ->orderBy('order')
            ->get();

        $languages = Language::query()
            ->orderByDesc('percentage')
            ->get();

        return Inertia::render('Home', [
            'profile' => $profile,
            'projects' => $projects,
            'experiences' => $experiences,
            'education' => $education,
            'interests' => $interests,
            'languages' => $languages,
        ]);
    }
}
