<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Informations de la certification')
                    ->schema([

                        TextInput::make('name')
                            ->label('Nom de la certification')
                            ->required()
                            ->maxLength(255),


                        TextInput::make('issuer')
                            ->label('Organisme émetteur')
                            ->required()
                            ->maxLength(255),


                        DatePicker::make('issue_date')
                            ->label('Date d’obtention')
                            ->native(false)
                            ->displayFormat('d/m/Y'),


                        DatePicker::make('expiration_date')
                            ->label('Date d’expiration')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                    ])
                    ->columns(2),



                Section::make('Détails')
                    ->schema([

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->columnSpanFull(),

                    ]),



                Section::make('Preuve et vérification')
                    ->schema([

                        TextInput::make('credential_id')
                            ->label('ID de certification')
                            ->maxLength(255),


                        TextInput::make('credential_url')
                            ->label('Lien de vérification')
                            ->url()
                            ->maxLength(255),


                        FileUpload::make('certificate_file')
                            ->label('Certificat')
                            ->disk('public')
                            ->directory('certifications')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/*',
                            ]),

                    ])
                    ->columns(2),

            ]);
    }
}
