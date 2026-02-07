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
                'name' => 'master',
                'display_name' => 'Master',
                'description' => 'Master user with full system control'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator with administrative privileges'
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Regular user with limited access'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
