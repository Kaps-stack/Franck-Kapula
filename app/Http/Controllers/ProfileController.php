<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        $profile = Profile::first();

        return Inertia::render('Profile/Index', [
            'profile' => $profile,
        ]);
    }
}
