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
                'name' => 'adminPN',
                'position_name' => 'super_admin',
                'interface' => 'admin_pn'
            ],
            [
                'name' => 'adminMIP',
                'position_name' => 'super_admin',
                'interface' => 'admin_mip'
            ],

            [
                'name' => 'contentManagerMIP',
                'position_name' => 'admin_mip',
                'interface' => 'admin_mip'
            ],
            [
                'name' => 'contentManagerPN',
                'position_name' => 'admin_pn',
                'interface' => 'admin_pn'
            ],
            [
                'name' => 'operatorMIP',
                'position_name' => 'admin_mip',
                'interface' => 'admin_mip'
            ],
            [
                'name' => 'operatorPN',
                'position_name' => 'admin_pn',
                'interface' => 'admin_pn'
            ],




        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }

    }

}
