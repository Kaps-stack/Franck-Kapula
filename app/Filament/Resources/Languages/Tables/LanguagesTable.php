<?php

namespace App\Filament\Resources\Languages\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ProgressColumn;
use Filament\Tables\Table;

class LanguagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Langue')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('level')
                    ->label('Niveau')
                    ->searchable(),


                TextColumn::make('percentage')
                    ->label('Maîtrise')
                    ->suffix('%')
                    ->sortable(),


                IconColumn::make('featured')
                    ->label('Mise en avant')
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
