<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informations du contact')
                    ->schema([

                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                    ])
                    ->columns(2),

                Section::make('Message')
                    ->schema([

                        TextInput::make('subject')
                            ->label('Objet')
                            ->maxLength(255),

                        Textarea::make('message')
                            ->label('Message')
                            ->rows(8)
                            ->columnSpanFull(),

                    ]),

                Section::make('Statut')
                    ->schema([

                        DateTimePicker::make('read_at')
                            ->label('Lu le')
                            ->seconds(false),

                    ]),

            ]);
    }
}
