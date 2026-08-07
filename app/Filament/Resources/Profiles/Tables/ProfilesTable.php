<?php

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('avatar')
                    ->label('Photo')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->avatar))
                    ->size(50)
                    ->url(fn ($record) => asset('storage/' . $record->avatar))
                    ->openUrlInNewTab(),


                TextColumn::make('full_name')
                    ->label('Nom complet')
                    ->searchable(),


                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),


                TextColumn::make('email')
                    ->label('Email'),


                TextColumn::make('location')
                    ->label('Localisation'),


                TextColumn::make('phone')
                    ->label('Téléphone'),


                TextColumn::make('github_url')
                    ->label('GitHub')
                    ->url(fn ($record) => $record->github_url)
                    ->openUrlInNewTab(),


                TextColumn::make('linkedin_url')
                    ->label('LinkedIn')
                    ->url(fn ($record) => $record->linkedin_url)
                    ->openUrlInNewTab(),


                TextColumn::make('website_url')
                    ->label('Site web')
                    ->url(fn ($record) => $record->website_url)
                    ->openUrlInNewTab(),


                TextColumn::make('facebook_url')
                    ->label('Facebook')
                    ->url(fn ($record) => $record->facebook_url)
                    ->openUrlInNewTab(),


                TextColumn::make('x_url')
                    ->label('X')
                    ->url(fn ($record) => $record->x_url)
                    ->openUrlInNewTab(),


                TextColumn::make('instagram_url')
                    ->label('Instagram')
                    ->url(fn ($record) => $record->instagram_url)
                    ->openUrlInNewTab(),


                TextColumn::make('whatsapp_url')
                    ->label('WhatsApp')
                    ->url(fn ($record) => $record->whatsapp_url)
                    ->openUrlInNewTab(),


                TextColumn::make('cv')
                    ->label('Curriculum Vitae')
                    ->url(fn ($record) => asset('storage/' . $record->cv))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn () => 'Voir le CV'),

            ])

            ->actions([
                EditAction::make(),
            ]);
    }
}
