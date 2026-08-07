<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Langue')
                    ->schema([

                        TextInput::make('name')
                            ->label('Langue')
                            ->placeholder('Ex: Français')
                            ->required()
                            ->maxLength(255),


                        Select::make('level')
                            ->label('Niveau')
                            ->options([
                                'native' => 'Langue maternelle',
                                'fluent' => 'Courant',
                                'advanced' => 'Avancé',
                                'intermediate' => 'Intermédiaire',
                                'basic' => 'Débutant',
                            ])
                            ->required(),


                        TextInput::make('percentage')
                            ->label('Pourcentage de maîtrise')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),


                        Toggle::make('featured')
                            ->label('Afficher dans les compétences principales'),

                    ])
                    ->columns(2),

            ]);
    }
}
