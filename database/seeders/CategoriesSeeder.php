<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'governing_body_id' => 1,
                'title' => 'ՊՆ',
                'path' => 'governing_bodies/pn.png'
            ],

            [
                'id' => 2,
                'governing_body_id' => 2,
                'title' => 'ՄԻՊ',
                'path' => 'governing_bodies/mip.png'
            ]


        ];

        foreach ($categories as $category) {
            $path = $category['path'];
            $category['path'] = "public/$category[path]";

            Category::updateOrCreate( $category);

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
            $directory = storage_path('app/public/categories');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Копируем файл
            File::copy($sourcePath, $destinationPath);

        }

    }
}
