<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        $skills = Skill::query()
    ->orderBy('category')
    ->orderBy('name')
    ->get();

        return Inertia::render('Skills/Index', [
            'skills' => $skills,
        ]);
    }
}
