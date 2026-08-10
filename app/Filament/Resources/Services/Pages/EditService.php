<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Cloudinary\Cloudinary;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;


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
                        'folder' => 'portfolio/services',
                        'resource_type' => 'image',
                    ]
                );


            $data['icon'] = $upload['secure_url'];



            // Supprime le fichier temporaire local

            if (file_exists($path)) {
                unlink($path);
            }


        }



        return $data;

    }
}
