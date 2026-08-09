<?php

namespace App\Filament\Resources\Interests\Pages;


use App\Filament\Resources\Interests\InterestResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateInterest extends CreateRecord
{
    protected static string $resource = InterestResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (!empty($data['icon'])) {


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


            // Nettoyage du fichier local temporaire
            if (file_exists($path)) {
                unlink($path);
            }

        }


        return $data;

    }
}
