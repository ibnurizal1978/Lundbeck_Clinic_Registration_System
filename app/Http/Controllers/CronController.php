<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Twilio\Rest\Client;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    //Creates appointment record (on submission of create-appointment form)
    public function emailCron()
    {

        /*
        1. get status from sessions, find which status = 0
        2. if status = 0 and created_at > 15 min than now,
        2b. check on table last_cron, if last_cron < 15 min from now, exit
        3. check id nurse on table cron_receiver
        4. if table is empty, then,
        5. get data nurse order by created_at limit 1
        6. insert into table cron_receiver with this nurse id
        7. if table is not empty then,
        8. get data nurse where id > id on table cron_receiver
        9. update table cron_receiver with new nurse id
        7. send email
        */

        $session = DB::table('sessions')
            ->select('status')
            ->where('status', 0)
            ->count();
        
        if($session > 0)
        {
            //DB::enableQueryLog();
            $last_cron = DB::table('cron')
            ->select('user_id', 'created_at')
            ->get();
            //dd(DB::getQueryLog());

            if(count($last_cron) == 0)
            {
                $hasil = 'masuk';
                $nurse = DB::table('users')
                ->select('id', 'contact_number')
                ->where('role_id', 2)
                ->where('status', 1)
                ->orderBy('created_at')
                ->limit(1)
                ->get();

                $insert_cron = DB::table('cron')->insert([
                    'user_id'       => $nurse[0]->id,
                    'created_at'    => now()
                ]);

               /* $subject = "Pending Appointment (UAT)";
                $message = "Pending Appointment (UAT)";
                $to = $nurse[0]->email;
                app('App\Http\Controllers\MailerController')->sendemailSingle($subject, $message, $to); */
                $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

                $client = new Client($account_sid, $auth_token);

                $session =  DB::table('sessions')
                ->select('id')
                ->where('status', 0)
                ->get();

                foreach($session as $row)
                {
                    $url = url('/') . "/confirm/" . $row->id;
                    $message = "(UAT) A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";
                    $client->messages->create(env('TWILIO_COUNTRY_CODE') . $nurse[0]->contact_number, [
                        'from' => $twilio_number,
                        'body' => $message
                    ]);
                }

            }else{

                $new_time = strtotime($last_cron[0]->created_at);
                if (time() - $new_time > 15 * 60) //if time from cron vs now is more than 15 mins?
                {

                    $hasil = 'udah 15 menit';
                    $nurse = DB::table('users')
                    ->select('id', 'contact_number')
                    ->where('id', '>', $last_cron[0]->user_id)
                    ->where('role_id', 2)
                    ->where('status', 1)
                    ->limit(1)
                    ->get();

                    if(count($nurse) == 0)
                    {
                        $nurse = DB::table('users')
                        ->select('id', 'contact_number')
                        ->where('role_id', 2)
                        ->where('status', 1)
                        ->orderBy('created_at')
                        ->limit(1)
                        ->get();  
                    }

                    $update_cron = DB::table('cron')
                    ->update([
                        'user_id'       => $nurse[0]->id,
                        'created_at'    => now()  
                    ]);

                    /*$subject = "Pending Appointment (UAT)";
                    $message = "Pending Appointment (UAT)";
                    $to = $nurse[0]->email;
                    app('App\Http\Controllers\MailerController')->sendemailSingle($subject, $message, $to);*/
                    $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                    $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                    $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');
    
                    $client = new Client($account_sid, $auth_token);
    
                    $session =  DB::table('sessions')
                    ->select('id')
                    ->where('status', 0)
                    ->get();
    
                    foreach($session as $row)
                    {
                        $url = url('/') . "/confirm/" . $row->id;
                        //echo $nurse[0]->contact_number.'<br/>';
                        $message = "(UAT) A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";
                        $client->messages->create(env('TWILIO_COUNTRY_CODE') . $nurse[0]->contact_number, [
                            'from' => $twilio_number,
                            'body' => $message
                        ]);
                    }

                }else{

                    $hasil = 'belum 15 menit';
                    
                }
            
            }

        }else{
            $hasil = "piye";
        }

        return $hasil;


        
        //DB::enableQueryLog();
                //dd(DB::getQueryLog());
                
    
        /*$appointment_info =  "<html>
                                <head></head>
                                <body>
                                    <table border='0'>
                                        <tr><td>APPOINTMENT DETAILS</td></tr>
                                        <tr><td>Clinic Name: " . $details[0]->clinic_name . "</td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td>TREATMENT DETAILS</td></tr>
                                        <tr><td>Treatment: " . $details[0]->treatment_name . "</td></tr>
                                        <tr><td>Location: " . $details[0]->address . "</td></tr>
                                        <tr><td>Date: " . $details[0]->date . "</td></tr>
                                        <tr><td>Time: " . $details[0]->time_start . " - " . $details[0]->time_end . "</td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td>Status: " . $status . "</td></tr>
                                    </table>
                                </body>
                            </html>";
                            $appointment_info = 'uat';                    
        $message = $start . "<br/><br/>" . $appointment_info;*/
        
        // send email
        //app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $staffs);
        //app('App\Http\Controllers\MailerController')->sendemail('Test UAT', 'message test', 'topfuturetechmail@gmail.com');
        //return redirect('home')->with('message', 'Appointment Created Successfully');
    }

    public function emailTest()
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
        //clinic
        $clinic = DB::table('appointments')
        ->select('users.id', 'users.name', 'users.email')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->get()->toArray();
        
        DB::enableQueryLog();
        $staffs = DB::table('users')
        ->select('email')
        ->whereIn('role_id', [1,3,4,5])
        ->where('status', "1")
        ->where('receive', "1")
        ->get()->toArray();
        
        app('App\Http\Controllers\MailerController')->sendemail('Test UAT (2)', 'message test', $staffs, $staffs);
        //app('App\Http\Controllers\MailerController')->sendemailSingle('Test UAT', 'message test', 'topfuturetechmail@gmail.com');
    }

}
