<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'title' => 'Համազգեստով քաղաքացի'
            ],
            [
                'id' => 2,
                'title' => 'Ապագա զորակոչիկների իրավունքները'
            ],
            [
                'id' => 3,
                'title' => 'Հիմնական իրավական ակտեր'
            ],
            [
                'id' => 4,
                'title' => 'ՄԻՊ'
            ],
            [
                'id' => 5,
                'title' => 'ՊՆ'
            ]


        ];

        foreach ($categories as $category) {
            Category::updateOrCreate( $category);
        }
    }
}
