<?php

namespace App\Filament\Resources\Trainings\Pages;

use App\Filament\Resources\Trainings\TrainingResource;
use Cloudinary\Cloudinary;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTraining extends EditRecord
{
    protected static string $resource = TrainingResource::class;


    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {


        if (
            !empty($data['certificate_file']) &&
            $data['certificate_file'] !== $this->record->certificate_file
        ) {


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



            // Suppression du fichier temporaire local

            if (file_exists($path)) {
                unlink($path);
            }


        }


        return $data;

    }
}
