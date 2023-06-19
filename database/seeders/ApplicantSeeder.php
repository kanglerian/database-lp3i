<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicants')->insert([
            'name' => 'Muhammad Kamaludin A. Rigai',
            'email' => 'rigai.lp3i@gmail.com',
            'phone' => '081286501015',
            'school' => 'SMAN 1 Wolwal',
            'year' => '2017',
            'source' => 1,
            'status' => 0,
            'nik_user' => '201702102'
        ]);
    }
}
