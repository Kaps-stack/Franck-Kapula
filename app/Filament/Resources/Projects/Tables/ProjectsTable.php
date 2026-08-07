<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                 ImageColumn::make('image')
                    ->label('Image ')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->image))
                    ->size(50)
                    ->url(fn ($record) => asset('storage/' . $record->image))
                    ->openUrlInNewTab(),



                TextColumn::make('title')
                    ->label('Projet')
                    ->searchable(),



                TextColumn::make('category')
                    ->label('Catégorie')
                    ->searchable(),



                TextColumn::make('status')
                    ->label('Statut'),



                IconColumn::make('featured')
                    ->label('Mis en avant')
                    ->boolean(),



                TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y'),



                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y'),



                TextColumn::make('demo_url')
                    ->label('Démo')
                    ->url(fn ($record) => $record->demo_url)
                    ->openUrlInNewTab(),



                TextColumn::make('github_url')
                    ->label('GitHub')
                    ->url(fn ($record) => $record->github_url)
                    ->openUrlInNewTab(),


            ])

            ->actions([
                EditAction::make(),
            ])


            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
