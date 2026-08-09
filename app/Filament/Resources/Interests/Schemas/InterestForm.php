<?php

namespace App\Filament\Resources\Interests\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class InterestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Centre d’intérêt')
                    ->schema([


                        TextInput::make('name')
                            ->label('Nom')
                            ->placeholder('Ex: Développement logiciel')
                            ->required()
                            ->maxLength(255),



                        FileUpload::make('icon')
                            ->label('Icône')
                            ->image()
                            ->imageEditor()

                            ->disk('public')

                            ->directory('interests')

                            ->required(),



                        TextInput::make('order')
                            ->label('Ordre d’affichage')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),



                        Toggle::make('featured')
                            ->label('Afficher dans les centres d’intérêt principaux')
                            ->default(false),



                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Décrivez brièvement cet intérêt...')
                            ->rows(5)
                            ->columnSpanFull(),


                    ])
                    ->columns(2),


            ]);
    }
}
