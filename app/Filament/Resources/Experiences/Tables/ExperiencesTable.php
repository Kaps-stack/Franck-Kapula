<?php

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('company')
                    ->label('Entreprise')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('position')
                    ->label('Poste')
                    ->searchable()
                    ->sortable(),


               TextColumn::make('type')
    ->label('Type')
    ->formatStateUsing(fn ($state) => match ($state) {
        'internship' => 'Stage',
        'cdi' => 'CDI',
        'cdd' => 'CDD',
        'freelance' => 'Freelance',
        'contract' => 'Contrat',
        'volunteer' => 'Bénévolat',
        'other' => 'Autre',
        default => $state,
    }),


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


                IconColumn::make('current')
                    ->label('En cours')
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
