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
                'public_path' => 'governing_bodies/pn.png',
                'path' => 'categories/1/pn.png'

            ],

            [
                'id' => 2,
                'governing_body_id' => 2,
                'title' => 'ՄԻՊ',
                'public_path' => 'governing_bodies/mip.png',
                'path' => 'categories/2/mip.png'

            ]


        ];

        foreach ($categories as $category) {
            $path = $category['path'];
            $public_path = $category['public_path'];

            $category['path'] = "public/$category[path]";
            unset($category['public_path']);

            Category::updateOrCreate( $category);

            $this->copyFile($public_path, $path, $category['id']);
        }
    }

    public function copyFile($public_path, $path, $category_id)
    {
        // Исходный путь (путь из public/assets)
        $sourcePath = public_path("/assets/$public_path");

        // Путь назначения (storage/app/public/categories)
        $destinationPath = storage_path("/app/public/$path");

        // Проверка, существует ли исходный файл
        if (File::exists($sourcePath)) {
            // Создаём директорию, если её нет
            $directory = storage_path("app/public/categories/$category_id");
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Копируем файл
            File::copy($sourcePath, $destinationPath);

        }

    }
}
