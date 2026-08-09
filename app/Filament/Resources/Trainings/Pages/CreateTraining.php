<?php

namespace App\Filament\Resources\Trainings\Pages;

use App\Filament\Resources\Trainings\TrainingResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateTraining extends CreateRecord
{
    protected static string $resource = TrainingResource::class;


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
                        'folder' => 'portfolio/trainings',
                        'resource_type' => 'raw',
                    ]
                );


            $data['certificate_file'] = $upload['secure_url'];



            if (file_exists($path)) {
                unlink($path);
            }

        }


        return $data;

    }
}
