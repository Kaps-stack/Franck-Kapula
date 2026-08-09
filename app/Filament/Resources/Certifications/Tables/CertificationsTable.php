<?php

namespace App\Filament\Resources\Certifications\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class CertificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('name')
                    ->label('Certification')
                    ->searchable(),



                TextColumn::make('issuer')
                    ->label('Organisme')
                    ->searchable(),



                TextColumn::make('issue_date')
                    ->label('Date d’obtention')
                    ->date('d/m/Y'),



                TextColumn::make('expiration_date')
                    ->label('Expiration')
                    ->date('d/m/Y'),



                TextColumn::make('credential_id')
                    ->label('ID')
                    ->searchable(),




                TextColumn::make('certificate_file')
                    ->label('Certificat')
                    ->formatStateUsing(fn () => 'Voir le certificat')
                    ->url(fn ($record) => $record->certificate_file)
                    ->openUrlInNewTab(),




                TextColumn::make('credential_url')
                    ->label('Vérification')
                    ->url(fn ($record) => $record->credential_url)
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
