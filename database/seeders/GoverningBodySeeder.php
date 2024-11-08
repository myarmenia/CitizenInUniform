<?php

namespace Database\Seeders;

use App\Models\GoverningBody;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Log;
class GoverningBodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $governing_bodies = [
            [
                'id' => 1,
                'name' => 'Պաշտպանության նախարարություն',
                'path' => 'governing_bodies/pn.png'


            ],
            [
                'id' => 2,
                'name' => 'ՄԻՊ գրասենյակ',
                'path' => 'governing_bodies/mip.png'

            ]


        ];

        foreach ($governing_bodies as $body) {
            $path =  $body['path'];
            $body['path'] = "public/$body[path]";
            
            GoverningBody::updateOrCreate($body);

            $this->copyFile($path);
        }


    }

    public function copyFile($path)
    {
        // Исходный путь (путь из public/assets)
        $sourcePath = public_path("/assets/$path");

        // Путь назначения (storage/app/public/governing_body)
        $destinationPath = storage_path("/app/public/$path");

        // Проверка, существует ли исходный файл
        if (File::exists($sourcePath)) {
            // Создаём директорию, если её нет
            $directory = storage_path('app/public/governing_bodies');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Копируем файл
            File::copy($sourcePath, $destinationPath);

            Log::info('successfuly compleated');
        }

    }
}
