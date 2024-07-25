<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Session;
use App\Models\Clinic;
use DateTime;

class TwilioSMSController extends Controller
{
    /**

     * Write code on Method

     *

     * @return response()

     */
    public function sendsms($sessionId)
    {
        $url = url('/') . "/confirm/" . $sessionId;
        $message = "(UAT) A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";

        $nurses = User::where('role_id', 2)
->where('status', 1)
->where('receive', 1)
->orderBy('created_at','asc')
->limit(1)
->get();

        foreach ($nurses as $nurse) {
            echo $nurse->contact_number . "<br/>";

            try {
                $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

                $client = new Client($account_sid, $auth_token);

                $client->messages->create(env('TWILIO_COUNTRY_CODE') . $nurse->contact_number, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);

                echo $account_sid;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function sendSMSCC($message)
    {
        try {
            $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
            $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
            $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

            $ccs = User::where('send_cc', 1)->where('status', 1)->where('receive', "1")->get();

            if (sizeof($ccs) > 0) {
                foreach ($ccs as $cc) {
                    echo $cc->contact_number . "<br/>";

                    $client = new Client($account_sid, $auth_token);

                    $client->messages->create(env('TWILIO_COUNTRY_CODE') . $cc->contact_number, [
                        'from' => $twilio_number,
                        'body' => $message
                    ]);
                }
            }

            echo $account_sid;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function sendcancelsms($sessionId)
    {
        $session = Session::where('id', $sessionId)->first();
        $appointment = Appointment::where('id', $session->appointment_id)->first();
        $clinic = Clinic::where('id', $appointment->clinic_id)->first();

        // appointment date and hour
        $date = DateTime::createFromFormat('m-d-Y', $session->date);
        $appointmentdate = $date->format('Y M d');
        $appointmentstart = date("H:i", strtotime(str_replace('-', '/', $session->date) . ' ' . $session->time_start));
        $appointmentend = date("H:i", strtotime(str_replace('-', '/', $session->date) . ' ' . $session->time_end));

        $message = "(UAT) An appointment has been cancelled by the clinic. Medical Centre: {$clinic->medical_centre}, Date/Time: {$date->format('M d, Y')} at {$appointmentstart}-{$appointmentend}";

        $nurses = User::where('role_id', 2)->where('status', 1)->where('receive', 1)->get();

        foreach ($nurses as $nurse) {
            echo $nurse->contact_number . "<br/>";

            try {
                $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

                $client = new Client($account_sid, $auth_token);

                $client->messages->create(env('TWILIO_COUNTRY_CODE') . $nurse->contact_number, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);

                echo $account_sid;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function testsms()
    {
        $message = "this is a test sms";

        $nurses = User::where('role_id', 2)->where('status', 1)->where('receive', 1)->get();

        foreach ($nurses as $nurse) {
            echo $nurse->contact_number . "<br/>";

            try {
                $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

                $client = new Client($account_sid, $auth_token);

                $messages = $client->messages->create(env('TWILIO_COUNTRY_CODE') . $nurse->contact_number, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);

                echo "Message SID: {$messages->sid}";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    /** added by Rizal for slide 46 */
    public function sendsmstest()
    {
        $url = url('/') . "/confirm/";
        $message = "(UAT) godug: {$url}";
        //$no = '94265537'; //nomer nix
        $no = '96254652'; //nomer kah

            try {
                $account_sid = env('TWILIO_SID'); // env('TWILIO_SID');
                $auth_token = env('TWILIO_TOKEN'); // env('TWILIO_TOKEN');
                $twilio_number = env('TWILIO_FROM'); // env('TWILIO_FROM');

                $client = new Client($account_sid, $auth_token);

                $client->messages->create(env('TWILIO_COUNTRY_CODE') . $no, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);

                echo $account_sid;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
    
    }
    /** end added by Rizal */

}
