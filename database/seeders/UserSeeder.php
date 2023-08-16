<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'identity' => mt_rand(1, 1000000000),
            'name' => 'Administrator',
            'email' => 'lp3itasik@gmail.com',
            'password' => Hash::make('mimin311'),
            'phone' => '6281313608558',
            'role' => 'A',
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
