<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Training;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        /*
        |--------------------------------------------------------------------------
        | Pages principales
        |--------------------------------------------------------------------------
        */

        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('profile.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('projects.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('experiences.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('educations.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('awards.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('services.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('skills.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('interests.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('languages.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('trainings.index'),
            'lastmod' => now()->toAtomString(),
        ];

        $urls[] = [
            'loc' => route('game'),
            'lastmod' => now()->toAtomString(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Projets
        |--------------------------------------------------------------------------
        */

        Project::query()
            ->get()
            ->each(function (Project $project) use (&$urls) {
                $urls[] = [
                    'loc' => route('projects.show', $project),
                    'lastmod' => $project->updated_at?->toAtomString(),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Expériences
        |--------------------------------------------------------------------------
        */

        Experience::query()
            ->get()
            ->each(function (Experience $experience) use (&$urls) {
                $urls[] = [
                    'loc' => route('experiences.show', $experience),
                    'lastmod' => $experience->updated_at?->toAtomString(),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Formations
        |--------------------------------------------------------------------------
        */

        Education::query()
            ->get()
            ->each(function (Education $education) use (&$urls) {
                $urls[] = [
                    'loc' => route('educations.show', $education),
                    'lastmod' => $education->updated_at?->toAtomString(),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Récompenses
        |--------------------------------------------------------------------------
        */

        Award::query()
            ->get()
            ->each(function (Award $award) use (&$urls) {
                $urls[] = [
                    'loc' => route('awards.show', $award),
                    'lastmod' => $award->updated_at?->toAtomString(),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Formations / Trainings
        |--------------------------------------------------------------------------
        */

        Training::query()
            ->get()
            ->each(function (Training $training) use (&$urls) {
                $urls[] = [
                    'loc' => route('trainings.show', $training),
                    'lastmod' => $training->updated_at?->toAtomString(),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Génération XML
        |--------------------------------------------------------------------------
        */

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';

            $xml .= '<loc>';
            $xml .= htmlspecialchars($url['loc'], ENT_XML1);
            $xml .= '</loc>';

            if (!empty($url['lastmod'])) {
                $xml .= '<lastmod>';
                $xml .= htmlspecialchars($url['lastmod'], ENT_XML1);
                $xml .= '</lastmod>';
            }

            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
