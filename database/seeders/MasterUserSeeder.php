<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class MasterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Master User',
            'email' => 'master@example.com',
            'password' => \Hash::make('master123'),
            'role' => 'master',
            'status' => 'active',
        ]);
    }
}
