<?php

namespace App\Filament\Resources\Education\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('institution')
                    ->label('Établissement')
                    ->searchable(),



                TextColumn::make('degree')
                    ->label('Diplôme')
                    ->searchable(),



                TextColumn::make('field')
                    ->label('Domaine'),



                TextColumn::make('location')
                    ->label('Lieu'),



                TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y'),



                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y'),



                IconColumn::make('current')
                    ->label('En cours')
                    ->boolean(),



                TextColumn::make('institution_url')
                    ->label('Site')
                    ->url(fn ($record) => $record->institution_url)
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
