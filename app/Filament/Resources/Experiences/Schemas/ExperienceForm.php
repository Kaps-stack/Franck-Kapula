<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Expérience professionnelle')
                    ->schema([

                        TextInput::make('company')
                            ->label('Entreprise')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('position')
                            ->label('Poste occupé')
                            ->required()
                            ->maxLength(255),


                        Select::make('type')
                            ->label("Type d'expérience")
                            ->options([
                                'internship' => 'Stage',
                                'cdi' => 'CDI',
                                'cdd' => 'CDD',
                                'freelance' => 'Freelance',
                                'contract' => 'Contrat',
                                'volunteer' => 'Bénévolat',
                                'other' => 'Autre',
                            ])
                            ->required(),


                        TextInput::make('location')
                            ->label('Lieu')
                            ->maxLength(255),

                    ])
                    ->columns(2),


                Section::make('Période')
                    ->schema([

                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('Date de fin')
                            ->nullable(),

                        Toggle::make('current')
                            ->label('Actuellement en poste'),

                    ])
                    ->columns(3),


                Section::make('Description')
                    ->schema([

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->columnSpanFull(),

                    ]),


                Section::make('Lien')
                    ->schema([

                        TextInput::make('company_url')
                            ->label("Site de l’entreprise")
                            ->url()
                            ->maxLength(255),

                    ]),

            ]);
    }
}
