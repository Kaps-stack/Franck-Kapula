<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Informations du projet')
                    ->schema([


                        TextInput::make('title')
                            ->label('Titre')
                            ->placeholder('Ex: CopPlus, Système de gestion d’état civil')
                            ->required()
                            ->maxLength(255),



                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('Ex: copplus-platform')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),



                        Select::make('category')
                            ->label('Catégorie')
                            ->placeholder('Sélectionner une catégorie')
                            ->options([
                                'Web' => 'Web',
                                'Mobile' => 'Mobile',
                                'Desktop' => 'Desktop',
                                'IA' => 'Intelligence artificielle',
                                'IoT' => 'IoT',
                                'Autre' => 'Autre',
                            ]),



                        Select::make('status')
                            ->label('Statut')
                            ->placeholder('Sélectionner un statut')
                            ->options([
                                'completed' => 'Terminé',
                                'in_progress' => 'En cours',
                                'planned' => 'Prévu',
                            ]),



                        Toggle::make('featured')
                            ->label('Mettre en avant sur le portfolio')
                            ->helperText('Les projets mis en avant seront affichés en priorité.'),


                    ])
                    ->columns(2),


                    Select::make('skills')
                        ->label('Technologies utilisées')
                        ->relationship('skills', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->placeholder('Sélectionner les technologies')
                        ->columnSpanFull(),

                Section::make('Description')
                    ->schema([


                        Textarea::make('description')
                            ->label('Résumé')
                            ->placeholder('Ex: Plateforme mobile permettant de connecter clients et prestataires.')
                            ->rows(4)
                            ->columnSpanFull(),



                        Textarea::make('content')
                            ->label('Description complète')
                            ->placeholder('Décrivez le contexte, les fonctionnalités, les technologies utilisées et votre rôle dans le projet.')
                            ->rows(8)
                            ->columnSpanFull(),


                    ]),




                Section::make('Image')
                    ->schema([


                        FileUpload::make('image')
                            ->label('Image du projet')
                            ->placeholder('Importer une capture d’écran ou une image du projet')
                            ->image()
                            ->disk('public')
                            ->directory('projects'),


                    ]),




                Section::make('Liens')
                    ->schema([


                        TextInput::make('demo_url')
                            ->label('Lien de démonstration')
                            ->placeholder('Ex: https://mon-projet.com')
                            ->url()
                            ->maxLength(255),



                        TextInput::make('github_url')
                            ->label('Lien GitHub')
                            ->placeholder('Ex: https://github.com/utilisateur/projet')
                            ->url()
                            ->maxLength(255),


                    ])
                    ->columns(2),




                Section::make('Dates')
                    ->schema([


                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->placeholder('Sélectionner la date de début')
                            ->native(false),



                        DatePicker::make('end_date')
                            ->label('Date de fin')
                            ->placeholder('Sélectionner la date de fin')
                            ->native(false),


                    ])
                    ->columns(2),


            ]);
    }
}
