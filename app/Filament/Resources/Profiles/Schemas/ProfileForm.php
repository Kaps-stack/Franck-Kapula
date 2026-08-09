<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Informations personnelles')
                    ->schema([

                        TextInput::make('full_name')
                            ->label('Nom complet')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('title')
                            ->label('Titre professionnel')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('location')
                            ->label('Localisation')
                            ->maxLength(255),


                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),


                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->maxLength(50),

                    ])
                    ->columns(2),



                Section::make('Présentation')
                    ->schema([

                        Textarea::make('bio')
                            ->label('Biographie')
                            ->rows(6)
                            ->columnSpanFull(),

                    ]),



                Section::make('Photo et CV')
                    ->schema([

                        FileUpload::make('avatar')
                            ->label('Photo de profil')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('profile/avatar'),



                        FileUpload::make('cv')
                            ->label('CV PDF')
                            ->disk('public')
                            ->directory('profile/cv')
                            ->acceptedFileTypes([
                                'application/pdf',
                            ]),


                    ])
                    ->columns(2),



                Section::make('Réseaux sociaux')
                    ->schema([


                        TextInput::make('github_url')
                            ->label('GitHub')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('x_url')
                            ->label('X')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('whatsapp_url')
                            ->label('WhatsApp')
                            ->url()
                            ->maxLength(255),


                        TextInput::make('website_url')
                            ->label('Site web')
                            ->url()
                            ->maxLength(255),


                    ])
                    ->columns(2),


            ]);
    }
}
