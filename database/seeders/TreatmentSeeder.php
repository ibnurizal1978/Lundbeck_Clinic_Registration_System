<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('treatments')->insert([
            'name' => '100 MG',
            'no_sessions' => '4',
            'description' => '100 MG',
            'frequency_days' => '30',
            'status' => '1',
        ]);
    }
}
