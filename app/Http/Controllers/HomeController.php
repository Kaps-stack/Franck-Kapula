<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
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

        return Inertia::render('Home', [
            'profile' => $profile,
            'projects' => $projects,
            'experiences' => $experiences,
            'education' => $education,
        ]);
    }
}
