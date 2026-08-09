<?php


namespace App\Filament\Resources\Services\Schemas;


use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Informations du service')
                    ->schema([


                        TextInput::make('title')
                            ->label('Nom du service')
                            ->placeholder('Ex: Développement Web et Mobile')
                            ->required()
                            ->maxLength(255),



                        TextInput::make('order')
                            ->label('Ordre d’affichage')
                            ->placeholder('Ex: 1')
                            ->numeric()
                            ->default(0),



                        Toggle::make('featured')
                            ->label('Mettre en avant')
                            ->helperText('Afficher ce service en priorité sur le portfolio.'),


                    ])
                    ->columns(2),





                Section::make('Description')
                    ->schema([



                        Textarea::make('description')
                            ->label('Description du service')
                            ->placeholder('Ex: Création d’applications web modernes avec Laravel, Vue.js et Tailwind CSS.')
                            ->rows(6)
                            ->columnSpanFull(),



                    ]),





                Section::make('Icône')
                    ->schema([



                        FileUpload::make('icon')
                            ->label('Icône du service')
                            ->placeholder('Importer une icône')
                            ->image()
                            ->disk('cloudinary')
                            ->directory('services'),



                    ]),



            ]);
    }
}
