<?php


namespace App\Filament\Resources\Skills\Tables;


use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;


class SkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([



                ImageColumn::make('icon')
                    ->label('Icône')
                    ->size(50)
                    ->url(fn ($record) => $record->icon)
                    ->openUrlInNewTab(),



                TextColumn::make('name')
                    ->label('Compétence')
                    ->searchable(),




                TextColumn::make('category')
                    ->label('Catégorie')
                    ->searchable(),




                TextColumn::make('level')
                    ->label('Niveau')
                    ->suffix('%'),




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
