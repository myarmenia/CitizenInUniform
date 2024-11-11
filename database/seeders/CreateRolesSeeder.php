<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'position_name' => 'super_admin',
                'interface' => 'super_admin'
            ],
            [
                'name' => 'admin',
                'position_name' => 'super_admin',
                'interface' => 'admin'
            ],
            [
                'name' => 'content_manager',
                'position_name' => 'admin',
                'interface' => 'admin'
            ],
            [
                'name' => 'operatorMIP',
                'position_name' => 'admin',
                'interface' => 'admin'
            ],
            [
                'name' => 'operatorPN',
                'position_name' => 'admin',
                'interface' => 'admin'
            ],


        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }

    }

}
