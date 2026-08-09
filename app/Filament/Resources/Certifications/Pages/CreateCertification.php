<?php

namespace App\Filament\Resources\Certifications\Pages;


use App\Filament\Resources\Certifications\CertificationResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateCertification extends CreateRecord
{
    protected static string $resource = CertificationResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (!empty($data['certificate_file'])) {


            $cloudinary = new Cloudinary(
                env('CLOUDINARY_URL')
            );


            $path = storage_path(
                'app/public/' . $data['certificate_file']
            );


            $upload = $cloudinary
                ->uploadApi()
                ->upload(
                    $path,
                    [
                        'folder' => 'portfolio/certifications',
                        'resource_type' => 'auto',
                    ]
                );


            $data['certificate_file'] = $upload['secure_url'];


            // Supprime le fichier temporaire local
            if (file_exists($path)) {
                unlink($path);
            }

        }


        return $data;

    }
}
