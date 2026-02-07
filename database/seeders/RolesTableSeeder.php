<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Super Admin user with full system control'
            ],
            [
                'name' => 'admin',
                'display_name' => 'admin',
                'description' => 'Admin with administrative privileges'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
