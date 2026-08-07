<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Inertia\Inertia;
use Inertia\Response;

class CertificationController extends Controller
{
    public function index(): Response
    {
        $certifications = Certification::query()
            ->orderByDesc('issue_date')
            ->get();

        return Inertia::render('Certifications/Index', [
            'certifications' => $certifications,
        ]);
    }

    public function show(Certification $certification): Response
    {
        return Inertia::render('Certifications/Show', [
            'certification' => $certification,
        ]);
    }
}
