<?php

namespace App\Filament\Resources\Projects\Pages;


use App\Filament\Resources\Projects\ProjectResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;



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
                        'folder' => 'portfolio/projects',
                        'resource_type' => 'image',
                    ]
                );



            $data['image'] = $upload['secure_url'];



            // Supprime l'image locale après upload
            if (file_exists($path)) {
                unlink($path);
            }


        }



        return $data;

    }
}
