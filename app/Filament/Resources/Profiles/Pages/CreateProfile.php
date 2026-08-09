<?php

namespace App\Filament\Resources\Profiles\Pages;


use App\Filament\Resources\Profiles\ProfileResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $cloudinary = new Cloudinary(
            env('CLOUDINARY_URL')
        );


        /*
        |--------------------------------------------------------------------------
        | Avatar
        |--------------------------------------------------------------------------
        */

        if (!empty($data['avatar'])) {


            $path = storage_path(
                'app/public/' . $data['avatar']
            );


            $upload = $cloudinary
                ->uploadApi()
                ->upload(
                    $path,
                    [
                        'folder' => 'portfolio/profile/avatar',
                        'resource_type' => 'image',
                    ]
                );


            $data['avatar'] = $upload['secure_url'];


            if (file_exists($path)) {
                unlink($path);
            }

        }



        /*
        |--------------------------------------------------------------------------
        | CV PDF
        |--------------------------------------------------------------------------
        */

        if (!empty($data['cv'])) {


            $path = storage_path(
                'app/public/' . $data['cv']
            );


            $upload = $cloudinary
                ->uploadApi()
                ->upload(
                    $path,
                    [
                        'folder' => 'portfolio/profile/cv',
                        'resource_type' => 'raw',
                    ]
                );


            $data['cv'] = $upload['secure_url'];


            if (file_exists($path)) {
                unlink($path);
            }

        }


        return $data;

    }
}
