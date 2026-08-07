<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Inertia\Inertia;
use Inertia\Response;

class InterestController extends Controller
{
    public function index(): Response
    {
        $interests = Interest::where('featured', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('Interests/Index', [
            'interests' => $interests,
        ]);
    }
}
