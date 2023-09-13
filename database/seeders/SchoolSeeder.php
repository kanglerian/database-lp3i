<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')->insert([
            [
                'name' => 'SMKN 1 Kota Tasikmalaya',
                'region' => 'Kota Tasikmalaya'
            ],[
                'name' => 'SMKN 2 Kota Tasikmalaya',
                'region' => 'Kota Tasikmalaya'
            ],
        ]);
    }
}
