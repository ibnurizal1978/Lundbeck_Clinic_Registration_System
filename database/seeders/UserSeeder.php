<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserSeeder extends Seeder
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
                'name' => 'clinic',
                'contact_number' => '1111111111111',
                'email' => 'clinic@gmail.com',
                'role_id' => '1',
                'clinic_id' => '2',
                'comm_mode' => 'email',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('lundbeck123'),
                'status' => '1',
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'nurse',
                'contact_number' => '83839866',
                'email' => 'nurse@gmail.com',
                'role_id' => '2',
                'clinic_id' => '29',
                'comm_mode' => 'email',
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'password' => Hash::make('lundbeck123'),
                'status' => '1',
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            // [
            //     'name' => 'staff',
            //     'contact_number' => '1111111111111',
            //     'email' => 'staff@gmail.com',
            //     'role_id' => '3',
            //     'clinic_id' => null,
            //     'comm_mode' => 'email',
            //     'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'password' => Hash::make('lundbeck123'),
            //     'status' => '1',
            //     'remember_token' => '',
            //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
            // [
            //     'name' => 'superAdmin',
            //     'contact_number' => '1111111111111',
            //     'email' => 'superadmin@gmail.com',
            //     'role_id' => '4',
            //     'clinic_id' => null,
            //     'comm_mode' => 'email',
            //     'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'password' => Hash::make('lundbeck123'),
            //     'status' => '1',
            //     'remember_token' => '',
            //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            // ],
        ]);
    }
}
