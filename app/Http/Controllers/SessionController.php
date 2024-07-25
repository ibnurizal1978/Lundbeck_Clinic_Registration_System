<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{

    // create session
    //in :session data
    public function create_session(Request $request)
    {
        $session = new Session();

        $sessiontime = explode(" - ", $request->get('time'));

        $token = md5(Carbon::now()->toDateTimeString());

        $session->time_start = trim($sessiontime[0]);
        $session->time_end = trim($sessiontime[1]);
        $session->date = date("m-d-Y", strtotime($request->date));
        $session->appointment_id = $request->appointment_id;
        $session->status = "0"; //for pending
        $session->remarks = "";
        $session->payment_status = "paid";
        $session->session_no = "1";
        $session->token = $token;
        $session->created_at = Carbon::now();
        $session->save();

        // send sms
        if (env('SEND_SMS')) {
            app('App\Http\Controllers\TwilioSMSController')->sendsms($session->id);

            //Send SMS CC
            $url = url('/') . "/confirm/" . $session->id;
            $message = "(UAT) A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";
            app('App\Http\Controllers\TwilioSMSController')->sendSMSCC($message);
        }

        $staff = "ralp@webpuppies.com.sg";
        $subject = "New Appointment (UAT)";
        $url = url('/') . "/confirm/" . $session->id;
        $message = "A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";

        // get all Lundbeck Staffs
        $staffs = DB::table('users')
            ->select('email')
            ->whereIn('role_id', [1,3,4,5])
            ->where('status', "1")
            ->where('receive', "1")
            ->get()->toArray();

        // send email
        app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $staffs);
    }

    // to delete an existing session.
    //in :session object
    public function delete_session(Request $request)
    {
        $session = Session::where('id', $request->get('id'))->first();
        if ($session != null) {
            $session->delete();
            return back()->withErrors(['message' => 'session deleted successfully']);
        } else {
            return back()->withErrors(['message' => 'session not found']);
        }
    }

    // to update a session details
    // in: session object (to change) and new data
    public function update_session(Request $request)
    {
        //this function will only update the feilds that are filled.
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database apart from status (checkbox)
        $session = Session::where('id', $request->get('id'))->first();
        if ($session != null) {
            if ($request->appointment_id != null) {
                $session->appointment_id = $request->get('appointment_id');
                $session->save();
            }
            if ($request->date != null) {
                $session->date = $request->get('date');
                $session->save();
            }
            if ($request->time_start != null) {
                $session->time_start = $request->get('time_start');
                $session->save();
            }
            if ($request->time_end != null) {
                $session->time_end = $request->get('time_end');
                $session->save();
            }
            if ($request->session_no != null) {
                $session->session_no = $request->get('session_no');
                $session->save();
            }
            if ($request->payment_status != null) {
                $session->payment_status = $request->get('payment_status');
                $session->save();
            }
            if ($request->remarks != null) {
                $session->remarks = $request->get('remarks');
                $session->save();
            }
            if ($request->status != true) {
                $session->status = $request->status;
                $session->save();
            } else {
                $session->status = true;
                $session->save();
            }
            $session->updated_at = Carbon::now();
            return back();
        } else {
            return back()->withErrors(['message' => 'session not found']);
        }
    }

    public function UpdateSession(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required',
            'date' => 'required',
            'session_id2' => 'required',
        ]);

        $session = Session::where('id', $request->get('session_id2'))->first();

        $time = explode(" - ", $request->get('time'));

        $session->time_start = $time[0];
        $session->time_end = $time[1];
        $session->date = date("m-d-Y", strtotime($request->get('date')));
        $session->status = 0;

        $session->save();

        // send sms
        if (env('SEND_SMS')) {
            app('App\Http\Controllers\TwilioSMSController')->sendsms($request->get('session_id2'));
        }

        $staff = "ralp@webpuppies.com.sg";
        $subject = "New Appointment (UAT)";
        $url = url('/') . "/confirm/" . $request->get('session_id2');
        $message = "A new vyepti treatment appointment has been created. Click this link to accept the appointment: {$url}";

        // get all Lundbeck Staffs
        $staffs = DB::table('users')
            ->select('email')
            ->whereIn('role_id', [3,4,5])
            ->where('status', "1")
            ->where('receive', "1")
            ->get()->toArray();

        // send email
        app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $staffs);

        return back()->with('success', 'Appointment has been updated.');
    }

    // to retrieve a session details
    // in: session id
    public function retrieve_session(Request $request)
    {
        $sessions = DB::table("sessions")->where('date', $request->get('date'))->get()->toArray();
        if ($sessions == null) {
            return null;
        } else {
            $session = new Session();
            for ($i = 0; $i < count($sessions); $i++) {
                if ($sessions[$i]->time_start == substr($request->get('time'), 0, 8)) {
                    return $sessions[$i];
                } else {
                    return null;
                }
            }
        }
    }

    public function CancelSession(Request $request)
    {
        $user = auth()->user();

        $session = Session::where('id', $request->session_id)->first();
        $session->status = -2;
        $session->save();

        // send sms
        if (env('SEND_SMS')) {
            app('App\Http\Controllers\TwilioSMSController')->sendcancelsms($request->session_id);
        }

        return true;
    }
}
