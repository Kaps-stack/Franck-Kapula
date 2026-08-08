<?php

namespace App\Filament\Resources\Awards\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;

class AwardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informations du prix')
                    ->schema([

                        TextInput::make('title')
                            ->label('Titre du prix')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('organization')
                            ->label('Organisation')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('type')
                            ->label('Type')
                            ->placeholder('Hackathon, Concours, Distinction...')
                            ->maxLength(255),


                        TextInput::make('position')
                            ->label('Position obtenue')
                            ->placeholder('1er prix, Gold, Silver...')
                            ->maxLength(255),


                        DatePicker::make('date')
                            ->label('Date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(),

                    ])
                    ->columns(2),



                Section::make('Description')
                    ->schema([

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->columnSpanFull(),

                    ]),



                Section::make('Preuve et lien')
                    ->schema([

                    FileUpload::make('image')
    ->label('Image / Certificat')
    ->image()
    ->disk('public')
    ->directory('awards')
    ->maxSize(20480)

    ->visibility('public')
    ->multiple(false)
    ->formatStateUsing(function ($state) {
        return $state ? [$state] : null;
    }),


                        TextInput::make('url')
                            ->label('Lien')
                            ->url()
                            ->maxLength(255),

                    ])
                    ->columns(2),

            ]);
    }
}
