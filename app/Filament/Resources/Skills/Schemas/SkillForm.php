<?php


namespace App\Filament\Resources\Skills\Schemas;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([



                Section::make('Informations compétence')
                    ->schema([



                        TextInput::make('name')
                            ->label('Nom de la compétence')
                            ->required()
                            ->maxLength(255),




                        TextInput::make('category')
                            ->label('Catégorie')
                            ->placeholder('Backend, Frontend, Mobile...')
                            ->maxLength(255),




                        TextInput::make('level')
                            ->label('Niveau (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),




                        Toggle::make('featured')
                            ->label('Afficher dans les compétences principales'),



                    ])
                    ->columns(2),




                Section::make('Icône')
                    ->schema([



                        FileUpload::make('icon')
                            ->label('Icône')
                            ->image()
                            ->disk('public')
                            ->directory('skills'),



                    ]),



            ]);
    }
}
