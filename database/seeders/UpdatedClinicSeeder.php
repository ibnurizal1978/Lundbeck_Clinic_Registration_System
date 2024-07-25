<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatedClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate clinic table first before inserting data
        DB::table('clinics')->truncate();

        DB::table('clinics')->insert([
            [
                'name' => 'Siow Neurology Headache And Pain Centre', 
                'customer_name' => 'Charles Siow Hua Chiang', 
                'medical_centre' => 'MTA', 
                'unit' => '#08 -59',
                'address' => 'Mt. Alvernia Hospital, #08 -59  820 Thomson Road Medical Centre D Singapore 574623', 
                'psp_code' => 'MTA-CSI', 
                'status' => '1'
            ], 
            [
                'name' => 'Siow Neurology Headache And Pain Centre', 
                'customer_name' => 'Charles Siow Hua Chiang', 
                'medical_centre' => 'MEN', 
                'unit' => '#11-54',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #11-54, 38 Irrawaddy Road Singapore 329563', 
                'psp_code' => 'MEN-CSI', 
                'status' => '1'
            ], 
            [
                'name' => 'KK Queck Neurology Centre', 
                'customer_name' => 'Queck Kian Kheng', 
                'medical_centre' => 'MTA', 
                'unit' => '#02-03',
                'address' => 'Mount Alvernia Hospital Medical Centre A, #02-03, Singapore 574623', 
                'psp_code' => 'MTA-QKK', 
                'status' => '1'
            ], 
            [
                'name' => 'Lee Kim En Neurology Pte Ltd', 
                'customer_name' => 'Lee Kim En', 
                'medical_centre' => 'MEH', 
                'unit' => '#11-14/15',
                'address' => 'Mount Elizabeth Medical Centre, #11-14/15, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-LKE', 
                'status' => '1'
            ], 
            [
                'name' => 'Singapore Neurology Practice Pte Ltd', 
                'customer_name' => 'Tang Kok Foo', 
                'medical_centre' => 'MEH', 
                'unit' => '#14-01',
                'address' => 'Mount Elizabeth Medical Centre, #14-01, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-TKF', 
                'status' => '1'
            ], 
            [
                'name' => 'Capernaum Neurology Pte Ltd', 
                'customer_name' => 'Wee Chee Keong', 
                'medical_centre' => 'MEH', 
                'unit' => '#14-04',
                'address' => 'Mount Elizabeth Medical Centre, #14-04, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-WCK', 
                'status' => '1'
            ], 
            [
                'name' => 'P N Chong Neurology Clinic', 
                'customer_name' => 'Chong Piang Ngok', 
                'medical_centre' => 'MEH', 
                'unit' => '#16-10',
                'address' => 'Mount Elizabeth Medical Centre, #16-10, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-CPN', 
                'status' => '1'
            ], 
            [
                'name' => 'Adrian Tan Neurology Practice Pte Ltd', 
                'customer_name' => 'Tan Keng Yew, Adrian', 
                'medical_centre' => 'MEH', 
                'unit' => '#05-09',
                'address' => 'Mount Elizabeth Medical Centre, #05-09, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-ATA', 
                'status' => '1'
            ], 
            [
                'name' => 'Yeow Neurology and Medical Centre Pte Ltd', 
                'customer_name' => 'Yeow Yew Kim', 
                'medical_centre' => 'MEH', 
                'unit' => '#06-05',
                'address' => 'Mount Elizabeth Medical Centre, #06-05, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-YYK', 
                'status' => '1'
            ], 
            [
                'name' => 'M Y Neurology & Medical Clinic', 
                'customer_name' => 'Michael Yap H L', 
                'medical_centre' => 'MEH', 
                'unit' => '#10-01',
                'address' => 'Mount Elizabeth Medical Centre, #10-01, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-MYA', 
                'status' => '1'
            ], 
            [
                'name' => 'Nei Neurology Clinic Pte Ltd', 
                'customer_name' => 'Nei I Ping', 
                'medical_centre' => 'MEH', 
                'unit' => '#11-04',
                'address' => 'Mount Elizabeth Medical Centre, #11-04, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-NIP', 
                'status' => '1'
            ], 
            [
                'name' => 'K H Ho Neurology & Medical Clinic', 
                'customer_name' => 'Ho King Hee', 
                'medical_centre' => 'GMC', 
                'unit' => '#09-04',
                'address' => 'Gleneagles Medical Centre, #09-04, 6 Napier Road, Singapore 258499', 
                'psp_code' => 'GMC-HKH', 
                'status' => '1'
            ], 
            [
                'name' => 'Neurology International Clinic', 
                'customer_name' => 'Mohammed Tauqeer Ahmad', 
                'medical_centre' => 'GMC', 
                'unit' => '#10-04',
                'address' => 'Gleneagles Medical Centre, #10-04, 6 Napier Road, Singapore 258499', 
                'psp_code' => 'GMC-MAT', 
                'status' => '1'
            ], 
            [
                'name' => 'Singapore Neurology & Sleep Centre', 
                'customer_name' => 'Lim Li Ling', 
                'medical_centre' => 'GMC', 
                'unit' => '#04-19',
                'address' => 'Gleneagles Medical Centre, #04-19, 6 Napier Road, Singapore 258499', 
                'psp_code' => 'GMC-LLL', 
                'status' => '1'
            ], 
            [
                'name' => 'Neurology And Neurophysiology Clinic', 
                'customer_name' => 'Tan Chai Beng', 
                'medical_centre' => 'GMC', 
                'unit' => '#05-39',
                'address' => 'Gleneagles Hospital, #05-39, 6A Napier Road, Singapore 258500', 
                'psp_code' => 'GMC-TCB', 
                'status' => '1'
            ], 
            [
                'name' => 'Paliwal Neurology Clinic', 
                'customer_name' => 'Prakash Rameshchandra Paliwal', 
                'medical_centre' => 'GMC', 
                'unit' => '#05-04',
                'address' => 'Gleneagles Medical Centre, #05-04, 6 Napier Road Singapore 258499', 
                'psp_code' => 'GMC-PRP', 
                'status' => '1'
            ], 
            [
                'name' => 'The Neurology Practice', 
                'customer_name' => 'Ravindra Singh Shekhawat', 
                'medical_centre' => 'MEN', 
                'unit' => '#07-38',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #07-38, 38 Irrawaddy Road, Singapore 329563', 
                'psp_code' => 'MEN-RSS', 
                'status' => '1'
            ], 
            [
                'name' => 'The Neurology Practice', 
                'customer_name' => 'Ravindra Singh Shekhawat', 
                'medical_centre' => 'FPM', 
                'unit' => '#12-11',
                'address' => 'Farrer Park Medical Centre, Connexion, #12-11, 1 Farrer Park Road, Singapore 217562', 
                'psp_code' => 'FPM-RSS', 
                'status' => '1'
            ], 
            [
                'name' => 'Pan Neurology, Epilepsy And Sleep Disorders Clinic', 
                'customer_name' => 'Pan Beng Siong, Andrew', 
                'medical_centre' => 'MEN', 
                'unit' => '#06-34',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #06-34, 38 Irrawaddy Road, Singapore 329563', 
                'psp_code' => 'MEN-APA', 
                'status' => '1'
            ], 
            [
                'name' => 'Ng John Neurology Practice', 
                'customer_name' => 'Ng John', 
                'medical_centre' => 'MEN', 
                'unit' => '#09-34',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #09-34, 38 Irrawaddy Road, Singapore 329563', 
                'psp_code' => 'MEN-JNG', 
                'status' => '1'
            ], 
            [
                'name' => 'Raffles Hospital Neuroscience', 
                'customer_name' => 'Alvin Seah Boon Heng', 
                'medical_centre' => 'RH', 
                'unit' => 'Level 9',
                'address' => '585 North Bridge Rd, Level 9 Raffles Specialist Centre, Singapore 188770', 
                'psp_code' => 'RHN-ASE', 
                'status' => '1'
            ], 
            [
                'name' => 'Raffles Hospital Neuroscience', 
                'customer_name' => 'Narayanaswamy Venketasubramanian Ramani', 
                'medical_centre' => 'RHN', 
                'unit' => 'Level 9',
                'address' => '585 North Bridge Rd, Level 9 Raffles Specialist Centre, Singapore 188770', 
                'psp_code' => 'RHN-NVR', 
                'status' => '1'
            ], 
            [
                'name' => 'Yeo Neurology And Clinical Neurophysiology', 
                'customer_name' => 'Yeo Poh Teck', 
                'medical_centre' => 'RSN', 
                'unit' => '#13-06',
                'address' => '101 Irrawaddy Rd, #13-06 Royal Square Novena, Singapore 329565', 
                'psp_code' => 'RSN-YPT', 
                'status' => '1'
            ], 
            [
                'name' => 'The Pain Clinic', 
                'customer_name' => 'Ho Kok Yuen', 
                'medical_centre' => 'MTA', 
                'unit' => '#07-59',
                'address' => 'Mt. Alvernia Hospital, #07-59  820 Thomson Road Medical Centre D Singapore 574623', 
                'psp_code' => 'MTA-HKY', 
                'status' => '1'
            ], 
            [
                'name' => 'Raffles Hospital Anaesthesiology', 
                'customer_name' => 'Ho Kok Yuen', 
                'medical_centre' => 'RHN', 
                'unit' => 'Level 12',
                'address' => '585 North Bridge Rd, Level 12 Raffles Specialist Centre, Singapore 188770', 
                'psp_code' => 'RHN-HKY', 
                'status' => '1'
            ], 
            [
                'name' => 'The Pain Specialists Pte Ltd', 
                'customer_name' => 'Yeo Sow Nam', 
                'medical_centre' => 'MEH', 
                'unit' => '#15-09',
                'address' => 'Mount Elizabeth Medical Centre, #15-09, 3 Mount Elizabeth Singapore 228510', 
                'psp_code' => 'MEH-YSN', 
                'status' => '1'
            ], 
            [
                'name' => 'Specialist Pain International Clinic', 
                'customer_name' => 'Chua Hai Lian Nicholas', 
                'medical_centre' => 'MEN', 
                'unit' => '#07-22',
                'address' => 'Mount Elizabeth Novena Specialist Centre, #07-22, 38 Irrawaddy Road, Singapore 329563', 
                'psp_code' => 'MEN-NCH', 
                'status' => '1'
            ], 
            [
                'name' => 'Singapore Paincare Centre', 
                'customer_name' => 'Lee Mun Kum Bernard', 
                'medical_centre' => 'PMC', 
                'unit' => '#18-03',
                'address' => 'Paragon Medical Centre, 290 Orchard Rd, #18-03, 238859', 
                'psp_code' => 'PMC-BLE', 
                'status' => '1'
            ], 
            [
                'name' => 'Nurse Agency', 
                'customer_name' => '', 
                'medical_centre' => '', 
                'unit' => '',
                'address' => '', 
                'psp_code' => '', 
                'status' => '1'
            ]
        ]);
    }
}
