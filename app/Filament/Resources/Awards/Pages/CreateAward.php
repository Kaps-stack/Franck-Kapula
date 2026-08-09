<?php

namespace App\Filament\Resources\Awards\Pages;

use App\Filament\Resources\Awards\AwardResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;

class CreateAward extends CreateRecord
{
    protected static string $resource = AwardResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (!empty($data['image'])) {


            $cloudinary = new Cloudinary(
                env('CLOUDINARY_URL')
            );


            $path = storage_path(
                'app/public/' . $data['image']
            );


            $upload = $cloudinary
                ->uploadApi()
                ->upload(
                    $path,
                    [
                        'folder' => 'portfolio/awards'
                    ]
                );


            $data['image'] = $upload['secure_url'];


            // suppression du fichier local
            if (file_exists($path)) {
                unlink($path);
            }

        }


        return $data;
    }
}
