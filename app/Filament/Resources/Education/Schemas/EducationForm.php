<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Formation')
                    ->schema([


                        TextInput::make('institution')
                            ->label('Établissement')
                            ->placeholder('Ex: Université Catholique du Congo')
                            ->required()
                            ->maxLength(255),



                        TextInput::make('degree')
                            ->label('Diplôme')
                            ->placeholder('Ex: Licence en Sciences Informatiques')
                            ->required()
                            ->maxLength(255),



                        TextInput::make('field')
                            ->label('Domaine d’étude')
                            ->placeholder('Ex: Informatique, Génie logiciel')
                            ->maxLength(255),



                        TextInput::make('location')
                            ->label('Localisation')
                            ->placeholder('Ex: Kinshasa, RDC')
                            ->maxLength(255),


                    ])
                    ->columns(2),




                Section::make('Période')
                    ->schema([


                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->placeholder('Sélectionner la date de début')
                            ->native(false),



                        DatePicker::make('end_date')
                            ->label('Date de fin')
                            ->placeholder('Sélectionner la date de fin')
                            ->native(false),



                        Toggle::make('current')
                            ->label('Formation en cours')
                            ->helperText('Active si cette formation est toujours en cours.'),


                    ])
                    ->columns(3),




                Section::make('Description')
                    ->schema([


                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Ex: Formation axée sur le développement logiciel, bases de données et systèmes informatiques.')
                            ->rows(5)
                            ->columnSpanFull(),


                    ]),




                Section::make('Lien')
                    ->schema([


                        TextInput::make('institution_url')
                            ->label('Site de l’établissement')
                            ->placeholder('Ex: https://www.ucc.ac.cd')
                            ->url()
                            ->maxLength(255),


                    ]),


            ]);
    }
}
