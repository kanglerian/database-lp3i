<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProgramTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('program_type')->insert([
            [
                'name' => 'Reguler Pagi',
                'code' => 'R',
                'status' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],
            [
                'name' => 'Reguler Sore',
                'code' => 'N',
                'status' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],
            [
                'name' => 'Rekognisi Pembelajaran Lampau',
                'code' => 'RPL',
                'status' => 1,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],
            [
                'name' => 'Belum diketahui',
                'code' => 'NONE',
                'status' => 0,
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]
        ]);
    }
}
