<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clinics')->insert([
            [
                'name' => 'Singapore Sports and Orthopaedic Clinic', 
                'customer_name' => '', 
                'medical_centre' => 'GMC', 
                'unit' => '#02-10/11',
                'address' => '6 Napier Road, #02-10/11 Gleneagles Medical Centre, Singapore 258499', 
                'psp_code' => 'GMC-MTU', 
                'status' => '1'
            ]
        ]);
    }
}
