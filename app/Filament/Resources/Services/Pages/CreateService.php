<?php


namespace App\Filament\Resources\Services\Pages;


use App\Filament\Resources\Services\ServiceResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;



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
                        'folder' => 'portfolio/services',
                        'resource_type' => 'image',
                    ]
                );



            $data['icon'] = $upload['secure_url'];



            // Supprime le fichier local temporaire
            if (file_exists($path)) {
                unlink($path);
            }


        }



        return $data;

    }
}
