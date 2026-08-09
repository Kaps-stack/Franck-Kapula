<?php

namespace App\Filament\Resources\Trainings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informations de la formation')
                    ->schema([

                        TextInput::make('title')
                            ->label('Titre de la formation')
                            ->placeholder('Ex: Formation Laravel avancé')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('organization')
                            ->label('Organisme')
                            ->placeholder('Ex: OpenClassrooms, Coursera, Google...')
                            ->required()
                            ->maxLength(255),


                        Select::make('category')
                            ->label('Catégorie')
                            ->placeholder('Choisir une catégorie')
                            ->options([
                                'Programmation' => 'Programmation',
                                'Web' => 'Développement Web',
                                'Mobile' => 'Développement Mobile',
                                'Cloud' => 'Cloud',
                                'Cybersécurité' => 'Cybersécurité',
                                'IA' => 'Intelligence Artificielle',
                                'Autre' => 'Autre',
                            ]),


                        TextInput::make('location')
                            ->label('Lieu')
                            ->placeholder('Ex: En ligne, Kinshasa RDC')
                            ->maxLength(255),


                    ])
                    ->columns(2),



                Section::make('Période et durée')
                    ->schema([

                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->placeholder('Sélectionner la date de début')
                            ->native(false),


                        DatePicker::make('end_date')
                            ->label('Date de fin')
                            ->placeholder('Sélectionner la date de fin')
                            ->native(false),


                        TextInput::make('duration')
                            ->label('Durée (heures)')
                            ->placeholder('Ex: 40')
                            ->numeric()
                            ->suffix('heures'),

                    ])
                    ->columns(3),



                Section::make('Description')
                    ->schema([

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Décris brièvement cette formation...')
                            ->rows(5)
                            ->columnSpanFull(),

                    ]),



                Section::make('Certificat et lien')
                    ->schema([

                        FileUpload::make('certificate_file')
                            ->label('Certificat')
                            ->disk('public')
                            ->directory('trainings')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/*',
                            ]),


                        TextInput::make('url')
                            ->label('Lien de la formation')
                            ->placeholder('Ex: https://coursera.org/...')
                            ->url()
                            ->maxLength(255),

                    ])
                    ->columns(2),

            ]);
    }
}
