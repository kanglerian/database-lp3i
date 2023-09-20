<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
            [
                'identity' => 6281313608558,
                'name' => 'Administrator',
                'email' => 'lp3itasik@gmail.com',
                'password' => Hash::make('mimin311'),
                'phone' => '6281313608558',
                'role' => 'A',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6282215614238,
                'name' => 'Nurul Ahyar',
                'email' => 'ahyar.lp3i@gmail.com',
                'password' => Hash::make('ahyar123'),
                'phone' => '6282215614238',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6282127356645,
                'name' => 'Benny Suryadi Rahman',
                'email' => 'benny.lp3i@gmail.com',
                'password' => Hash::make('benny123'),
                'phone' => '6282127356645',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6281947776090,
                'name' => 'Sindiana',
                'email' => 'sindiana.lp3i@gmail.com',
                'password' => Hash::make('sindiana123'),
                'phone' => '6281947776090',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6282127951392,
                'name' => 'Harli',
                'email' => 'harli.lp3i@gmail.com',
                'password' => Hash::make('harli123'),
                'phone' => '6282127951392',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6281220662033,
                'name' => 'Yanti',
                'email' => 'yanti.lp3i@gmail.com',
                'password' => Hash::make('yanti123'),
                'phone' => '6281220662033',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6282118936775,
                'name' => 'Ratna',
                'email' => 'ratna.lp3i@gmail.com',
                'password' => Hash::make('ratna123'),
                'phone' => '6282118936775',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}