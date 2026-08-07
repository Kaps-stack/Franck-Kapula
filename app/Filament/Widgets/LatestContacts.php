<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContacts extends BaseWidget
{
    protected static ?string $heading = 'Derniers messages';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Contact::query()
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Objet')
                    ->limit(40),

                Tables\Columns\IconColumn::make('read_at')
                    ->label('Lu')
                    ->boolean()
                    ->getStateUsing(
                        fn (Contact $record) => $record->read_at !== null
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5, 10, 25]);
    }
}
