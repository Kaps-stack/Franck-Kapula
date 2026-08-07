<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Inertia\Inertia;
use Inertia\Response;

class TrainingController extends Controller
{
    public function index(): Response
    {
        $trainings = Training::query()
            ->orderByDesc('start_date')
            ->get();

        return Inertia::render('Trainings/Index', [
            'trainings' => $trainings,
        ]);
    }

    public function show(Training $training): Response
    {
        return Inertia::render('Trainings/Show', [
            'training' => $training,
        ]);
    }
}
