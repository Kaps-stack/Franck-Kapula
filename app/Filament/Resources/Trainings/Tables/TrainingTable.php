<?php

namespace App\Filament\Resources\Trainings\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('title')
                    ->label('Formation')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('organization')
                    ->label('Organisme')
                    ->searchable()
                    ->sortable(),



                TextColumn::make('category')
                    ->label('Catégorie')
                    ->searchable(),



                TextColumn::make('location')
                    ->label('Lieu'),



                TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y')
                    ->sortable(),



                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),



                TextColumn::make('duration')
                    ->label('Durée')
                    ->suffix(' h')
                    ->sortable(),



                TextColumn::make('url')
                    ->label('Lien')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->placeholder('Aucun lien'),



                TextColumn::make('certificate_file')
                    ->label('Certificat')
                    ->formatStateUsing(fn ($state) => $state ? 'Voir certificat' : 'Aucun')
                    ->url(fn ($record) => $record->certificate_file
                        ? asset('storage/' . $record->certificate_file)
                        : null)
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
