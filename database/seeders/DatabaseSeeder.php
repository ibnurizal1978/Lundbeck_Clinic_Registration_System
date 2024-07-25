<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(TreatmentSeeder::class);
        $this->call(ClinicSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UpdatedClinicSeeder::class);

    }
}
