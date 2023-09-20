<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FileUploadSeeder::class,
            ProgramTypeSeeder::class,
            SourceSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            FollowUpSeeder::class,
        ]);
    }
}
