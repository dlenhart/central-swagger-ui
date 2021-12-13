<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialConfig extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('swagger_config')->insert([
            'name' => 'Simple API Documentation',
            'url' => 'http://localhost:8000/docs',
            'author' => 'Drew'
        ]);
    }
}
