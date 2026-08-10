<?php

namespace App\Filament\Resources\Interests\Pages;

use App\Filament\Resources\Interests\InterestResource;
use Cloudinary\Cloudinary;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInterest extends EditRecord
{
    protected static string $resource = InterestResource::class;


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {


        if (
            !empty($data['icon']) &&
            $data['icon'] !== $this->record->icon
        ) {


            $cloudinary = new Cloudinary(
                env('CLOUDINARY_URL')
            );


            $path = storage_path(
                'app/public/' . $data['icon']
            );


            $upload = $cloudinary
                ->uploadApi()
                ->upload(
                    $path,
                    [
                        'folder' => 'portfolio/interests',
                        'resource_type' => 'image',
                    ]
                );


            $data['icon'] = $upload['secure_url'];



            // Nettoyage du fichier temporaire local

            if (file_exists($path)) {
                unlink($path);
            }


        }


        return $data;

    }
}
