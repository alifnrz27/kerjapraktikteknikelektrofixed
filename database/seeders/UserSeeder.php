<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id'    => 1,
                'name' => 'admin',
                'username' => 'admin',
                'role_id' => 1,
                'email' => 'admin@el.itera.ac.id',
                'password' => bcrypt('12341234'),
                'email_verified_at' => now()
            ],
        ];

        User::insert($user);
    }
}
