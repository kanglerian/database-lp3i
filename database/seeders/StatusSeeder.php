<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicants_status')->insert([
            [
                'name' => 'Tidak diketahui',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'name' => 'Prospek',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'name' => 'Hot Prospek',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'name' => 'Daftar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'name' => 'Registrasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'name' => 'Batal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
