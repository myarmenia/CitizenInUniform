<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'id' => 1,
                'name' => 'Բջջային հավելվածի թարմացում'

            ],
            [
                'id' => 2,
                'name' => 'Բեվանդակության փոփոխություն'
            ],
            [
                'id' => 3,
                'name' => 'Այլ'
            ]


        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate($setting);
        }
    }
}
