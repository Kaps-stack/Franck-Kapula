<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Training;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PortfolioStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Expériences', Experience::count())
                ->description('Expériences professionnelles')
                ->icon('heroicon-o-briefcase')
                ->color('primary'),

            Stat::make('Parcours académique', Education::count())
                ->description('Diplômes et établissements')
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Formations', Training::count())
                ->description('Formations et certifications')
                ->icon('heroicon-o-book-open')
                ->color('info'),

            Stat::make('Messages', Contact::count())
                ->description('Messages reçus')
                ->icon('heroicon-o-envelope')
                ->color('warning'),

            Stat::make('Messages non lus', Contact::whereNull('read_at')->count())
                ->description('À traiter')
                ->icon('heroicon-o-envelope-open')
                ->color('danger'),

            Stat::make('Langues', Language::count())
                ->description('Langues maîtrisées')
                ->icon('heroicon-o-language')
                ->color('gray'),
        ];
    }
}
