<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::with('skills')
            ->latest()
            ->get();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function show(Project $project): Response
    {
        $project->load('skills');

        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
}
