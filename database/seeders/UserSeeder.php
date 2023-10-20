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
                'identity' => 6282219509698,
                'name' => 'Indri Fitrianasari, S.Kom',
                'email' => 'indri.lp3i@gmail.com',
                'password' => Hash::make('indri123'),
                'phone' => '6282219509698',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6282215614238,
                'name' => 'Nurul Ahyar, S.Sos',
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
                'name' => 'Benny Suryadi Rahman, SE',
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
                'name' => 'Sindiana, A.Md.M',
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
                'name' => 'Lilip Harlivandi Zakaria, S.Kom',
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
                'name' => 'Yanti Fadila Wahab, M.Pd',
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
                'name' => 'Ratna Sopiah, S.AB',
                'email' => 'ratna.lp3i@gmail.com',
                'password' => Hash::make('ratna123'),
                'phone' => '6282118936775',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'identity' => 6281286501015,
                'name' => 'Check',
                'email' => 'check.lp3i@gmail.com',
                'password' => Hash::make('check123'),
                'phone' => '6281286501013',
                'role' => 'P',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
