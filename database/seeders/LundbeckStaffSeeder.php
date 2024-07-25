<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LundbeckStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Lundbeck Staff 1',
                'contact_number' => '1111111111111',
                'email' => 'drbn@lundbeck.com',
                'role_id' => '3',
                'clinic_id' => null,
                'comm_mode' => 'email',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('lundbeck123'),
                'status' => '1',
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Lundbeck Staff 2',
                'contact_number' => '1111111111111',
                'email' => 'tasj@lundbeck.com',
                'role_id' => '3',
                'clinic_id' => null,
                'comm_mode' => 'email',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('lundbeck123'),
                'status' => '1',
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Super Admin',
                'contact_number' => '1111111111111',
                'email' => 'vyepti_sg_admin@lundbeck.com',
                'role_id' => '4',
                'clinic_id' => null,
                'comm_mode' => 'email',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('lundbeck123'),
                'status' => '1',
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
