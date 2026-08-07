<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                ImageColumn::make('icon')
                    ->label('Icone')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->icon))
                    ->size(50)
                    ->url(fn ($record) => asset('storage/' . $record->icon))
                    ->openUrlInNewTab(),



                TextColumn::make('title')
                    ->label('Service')
                    ->searchable(),



                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),



                TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),



                IconColumn::make('featured')
                    ->label('Mis en avant')
                    ->boolean(),


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
