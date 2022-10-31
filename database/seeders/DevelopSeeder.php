<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\v1\User::create(
            [
                'display_name' => 'dold_admin',
                'first_name' => 'Le',
                'last_name' => 'Do',
                'email' => 'ledo3012@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'account_type' => 'admin'
            ]
        );
    }
}
