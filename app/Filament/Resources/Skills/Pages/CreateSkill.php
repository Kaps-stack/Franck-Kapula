<?php


namespace App\Filament\Resources\Skills\Pages;


use App\Filament\Resources\Skills\SkillResource;
use Cloudinary\Cloudinary;
use Filament\Resources\Pages\CreateRecord;


class CreateSkill extends CreateRecord
{
    protected static string $resource = SkillResource::class;



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
                        'folder' => 'portfolio/skills',
                        'resource_type' => 'image',
                    ]
                );



            $data['icon'] = $upload['secure_url'];



            // Supprime le fichier local après upload
            if (file_exists($path)) {
                unlink($path);
            }


        }



        return $data;

    }
}
