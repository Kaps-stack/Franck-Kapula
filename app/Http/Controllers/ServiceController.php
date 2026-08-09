<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = Service::query()
            ->orderBy('order')
            ->get();

        return Inertia::render('Services/Index', [
            'services' => $services,
        ]);
    }
}
