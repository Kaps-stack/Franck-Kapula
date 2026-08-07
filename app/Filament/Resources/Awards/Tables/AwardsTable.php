<?php

namespace App\Filament\Resources\Awards\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\View;

class AwardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([




                ImageColumn::make('image')
                    ->label('Image / Certificat')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->image))
                    ->size(50)
                    ->url(fn ($record) => asset('storage/' . $record->image))
                    ->openUrlInNewTab(),

                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),



                TextColumn::make('organization')
                    ->label('Organisation')
                    ->searchable(),



                TextColumn::make('type')
                    ->label('Type')
                    ->searchable(),



                TextColumn::make('position')
                    ->label('Position'),



                TextColumn::make('date')
                    ->label('Date'),



                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),



                TextColumn::make('url')
                    ->label('URL')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),

            ])



            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
