<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('subject')
                    ->label('Objet')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(60)
                    ->wrap(),

                IconColumn::make('read_at')
                    ->label('Lu')
                    ->boolean()
                    ->getStateUsing(
                        fn ($record) => $record->read_at !== null
                    ),

                TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])

            ->actions([

                EditAction::make(),

                Action::make('reply')
                    ->label('Répondre')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->url(function ($record) {

                        $signature = <<<TEXT
Cordialement,

Franck Kapula
Développeur logiciel

Email : franckkapula1@gmail.com
LinkedIn : https://linkedin.com/in/franckkapula
GitHub : https://github.com/Kaps-stack
TEXT;

                        return 'https://mail.google.com/mail/?view=cm&fs=1'
                            . '&to=' . urlencode($record->email)
                            . '&body=' . urlencode($signature);
                    })
                    ->openUrlInNewTab(),

            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
