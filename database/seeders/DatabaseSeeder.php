<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get(base_path('database/seeders/sql/stores.sql')));
        DB::unprepared(File::get(base_path('database/seeders/sql/foods.sql')));
    }
}
