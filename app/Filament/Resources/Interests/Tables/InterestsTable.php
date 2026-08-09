<?php

namespace App\Filament\Resources\Interests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;


class InterestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('name')
                    ->label('Centre d’intérêt')
                    ->searchable()
                    ->sortable(),



                ImageColumn::make('icon')
                    ->label('Icône')
                    ->size(50)
                    ->url(fn ($record) => $record->icon)
                    ->openUrlInNewTab(),



                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->searchable(),



                TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),



                IconColumn::make('featured')
                    ->label('Mis en avant')
                    ->boolean(),


            ])


            ->defaultSort('order')


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
