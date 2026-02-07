<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => \Hash::make('12345678'),
                'role_id' => 1,
                'status' => 'active',
            ),
        );

        DB::table('users')->insert($data);
    }
}
