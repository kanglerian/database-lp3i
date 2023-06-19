<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nik' => '201702102',
            'name' => 'Lerian Febriana',
            'email' => 'kanglerian.lp3i@gmail.com',
            'role' => 'A',
            'password' => Hash::make('lerian'),
        ]);
    }
}
