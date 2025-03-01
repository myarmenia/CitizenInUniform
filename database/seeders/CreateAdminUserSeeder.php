<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'surname' => 'Adminyan',
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASS'))
        ]);

        $role = Role::updateOrCreate(['name' => 'super_admin', 'position_name' => 'super_admin',
        'interface' => 'super_admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
