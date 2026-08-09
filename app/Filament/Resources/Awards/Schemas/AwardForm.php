<?php

namespace App\Filament\Resources\Awards\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Cloudinary\Cloudinary;


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
                            ->placeholder('Gold, Silver, 1er prix...')
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

                            ->disk('local')

                            ->directory('temp')

                            ->required()

                            ->afterStateUpdated(function ($state, callable $set) {


                                if (!$state) {
                                    return;
                                }


                                $cloudinary = new Cloudinary(
                                    env('CLOUDINARY_URL')
                                );


                                $upload = $cloudinary
                                    ->uploadApi()
                                    ->upload(
                                        $state->getRealPath(),
                                        [
                                            'folder' => 'portfolio/awards'
                                        ]
                                    );


                                $set(
                                    'image',
                                    $upload['secure_url']
                                );


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
