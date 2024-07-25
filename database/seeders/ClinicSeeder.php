<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicSeeder extends Seeder
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
                'name' => 'Siow Neurology Headache And Pain Centre',
                'address' => ' Mt. Alvernia Hospital #08 -59  820 Thomson Road Medical Centre D Singapore 574623',
                'status' => '1',
            ],
            [
                'name' => 'KK Queck Neurology Centre',
                'address' => ' Mt. Alvernia Hospital #01-06 820 Thomson Road Medical Centre D Singapore 574623',
                'status' => '1',
            ],
            [
                'name' => 'Lee Kim En Neurology Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #11-14/15, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Singapore Neurology Practice Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #14-01, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Capernaum Neurology Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #14-04, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'P N Chong Neurology Clinic',
                'address' => 'Mount Elizabeth Medical Centre, #12-16, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Adrian Tan Neurology Practice Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #05-09, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Yeow Neurology and Medical Centre Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #06-05, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'M Y Neurology & Medical Clinic',
                'address' => 'Mount Elizabeth Medical Centre, #10-01, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Nei Neurology Clinic Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #11-04, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'K H Ho Neurology & Medical Clinic',
                'address' => 'Gleneagles Medical Centre, #09-04, 6 Napier Road, Singapore 258499',
                'status' => '1',
            ],
            [
                'name' => 'Neurology International Clinic',
                'address' => 'Gleneagles Medical Centre, #10-04, 6 Napier Road, Singapore 258499',
                'status' => '1',
            ],
            [
                'name' => 'Singapore Neurology & Sleep Centre',
                'address' => 'Gleneagles Medical Centre, #04-19, 6 Napier Road, Singapore 258499',
                'status' => '1',
            ],
            [
                'name' => 'Neurology And Neurophysiology Clinic',
                'address' => 'Gleneagles Hospital, #05-39, 6A Napier Road, Singapore 258500',
                'status' => '1',
            ],
            [
                'name' => 'The Neurology Practice',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #07-38, 38 Irrawaddy Road, Singapore 329563',
                'status' => '1',
            ],
            [
                'name' => 'Pan Neurology, Epilepsy And Sleep Disorders Clinic',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #06-34, 38 Irrawaddy Road, Singapore 329563',
                'status' => '1',
            ],
            [
                'name' => 'Ng John Neurology Practice (Mount Elizabeth)',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #09-34, 38 Irrawaddy Road, Singapore 329563',
                'status' => '1',
            ],
            [
                'name' => 'Ng John Neurology Practice (Farrer Park Medical Center)',
                'address' => 'Farrer Park Medical Centre, Connexion, Unit 12-11, 1 Farrer Park Road, Singapore 217562',
                'status' => '1',
            ],
            [
                'name' => 'Raffles Hospital Neuroscience',
                'address' => '585 North Bridge Rd, Level 9 Raffles Specialist Centre, Singapore 188770',
                'status' => '1',
            ],
            [
                'name' => 'Yeo Neurology And Clinical Neurophysiology',
                'address' => '101 Irrawaddy Rd, #13-06 Royal Square Novena, Singapore 329565',
                'status' => '1',
            ],
            [
                'name' => 'The Pain Clinic',
                'address' => 'Mt. Alvernia Hospital #07 -59  820 Thomson Road Medical Centre D Singapore 574623',
                'status' => '1',
            ],
            [
                'name' => 'The Pain Specialists Pte Ltd',
                'address' => 'Mount Elizabeth Medical Centre, #15-09, 3 Mount Elizabeth Singapore 228510',
                'status' => '1',
            ],
            [
                'name' => 'Specialist Pain International Clinic',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #07-22, 38 Irrawaddy Road, Singapore 329563',
                'status' => '1',
            ],
            [
                'name' => 'Raffles Hospital Anaesthesiology',
                'address' => '585 North Bridge Rd, Level 12 Raffles Specialist Centre, Singapore 188770',
                'status' => '1',
            ],
            [
                'name' => 'Singapore Paincare Centre',
                'address' => 'Paragon Medical Centre, 290 Orchard Rd, #18-03, 238859',
                'status' => '1',
            ],
            [
                'name' => 'Nurse Agency',
                'address' => '',
                'status' => '1',
            ],
        ]);
    }
}
