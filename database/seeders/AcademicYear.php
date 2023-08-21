<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AcademicYear extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('academic_year')->insert([
            [
                'year' => 2021,
            ],[
                'year' => 2022,
            ],[
                'year' => 2023,
            ],[
                'year' => 2024,
            ],[
                'year' => 2025,
            ],[
                'year' => 2026,
            ],[
                'year' => 2027,
            ],
        ]);
    }
}
