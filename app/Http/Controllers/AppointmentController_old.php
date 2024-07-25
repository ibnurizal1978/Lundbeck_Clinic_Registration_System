<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Session;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\PspRemark;
use App\Models\Treatment;
use App\Models\MasterTimes;
use Carbon\Carbon;
use Auth;
use App\Rules\ValidIC;

class AppointmentController extends Controller
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
    public function register(Request $request)
    {
        // validate form details
        $validated = $request->validate(
            [
                'patient_status'    => 'required',
                'existing_patient'  => 'required_if:patient_status,existing',
                'name'              => 'required_if:patient_status,new|unique:patients,name',
                'code'              => 'required_if:patient_status,new|unique:patients,patient_code',
                'fl_nric'           => 'required_if:patient_status,new',
                'cl_nric'           => 'required_if:patient_status,new',
                'l4_nric'           => ['required_if:patient_status,new', new ValidIC($request->get('patient_status'), $request->get('fl_nric'), $request->get('cl_nric'), $request->get('l4_nric'))],
                'treatment'         => 'required',
                'location'          => 'required',
                'date'              => 'required',
                'time'              => 'required',
            ],
            [
                'fl_nric.required_if' => 'The nric field is required when patient status is new.',
                'cl_nric.required_if' => 'The nric field is required when patient status is new.',
                'l4_nric.required_if' => 'The nric field is required when patient status is new.'
            ]
        );

        $patient_id = $request->get('existing_patient');

        // if new patient add it to patient records
        if ($request->get('patient_status') == "new") {
            $request->nric = $request->get('fl_nric') . $request->get('cl_nric') . $request->get('l4_nric');
            $request->patient_code = $request->get('code');
            $request->services_type_id = 1; //RZL
            $patient_id = app('App\Http\Controllers\PatientController')->create_patient($request);
        }

        $request->patient_id = $patient_id;
        $request->clinic_id = $request->get('location');
        $request->user_id = Auth::id();
        $request->treatment_id = Treatment::where('name', $request->get('treatment'))->first()->id;

        //create appointment record
        app('App\Http\Controllers\AppointmentController')->create_appointment($request);

        // create sessions
        app('App\Http\Controllers\SessionController')->create_session($request);

        return redirect('home')->with('message', 'Appointment Created Successfully');
    }

    // create appointment
    //in :appointment data
    public function create_appointment(Request $request)
    {
        $appointment = new Appointment();
        $appointment->user_id = $request->user_id; //these values were changed from the input entered in the form so they should be assigned individually
        $appointment->treatment_id = $request->treatment_id;
        $appointment->patient_id = $request->patient_id;
        $appointment->clinic_id = $request->clinic_id;

        $appointment->created_at = Carbon::now();

        $appointment->save();

        request()->appointment_id = $appointment->id;

        return;
    }


    // to delete an existing appointment.
    //in :appointment object
    public function delete_appointment(Request $request)
    {
        $appointment = Appointment::where('id', $request->get('id'))->first();
        $appointment->delete();
        return back()->withErrors(['message' => 'appointment deleted successfully']);
    }

    // to update a appointment details
    // in: appointment object (to change) and new data
    public function update_appointment(Request $request)
    {
        $appointment = Appointment::where('id', $request->get('id'))->first();

        if ($request->patient_id != null) {
            $appointment->patient_id = $request->get('patient_id');
            $appointment->save();
        }
        if ($request->clinic_id != null) {
            $appointment->clinic_id = $request->get('clinic_id');
            $appointment->save();
        }
        if ($request->user_id != null) {
            $appointment->user_id = $request->get('user_id');
            $appointment->save();
        }
        if ($request->treatment_id != null) {
            $appointment->treatment_id = $request->get('treatment_id');
            $appointment->save();
        }
        $appointment->updated_at = Carbon::now();
    }

    //updates the appointment's session
    public function UpdateRemarks(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required',
            'session_id' => 'required',
            'nurse_id'      => 'required',
            'nurse_name'    => 'required',
            'is_complete' => 'required'
        ]);

        $remarks = "";
        // if($request->get('is_complete') == "2") {
        $remarks = $request->get('remarks');
        // }

        $pspremark = PspRemark::updateOrCreate(
            ['session_id' => $request->get('session_id'), 'patient_id' => $request->get('patient_id')],
            [
                'answer1'       => $request->get('answer1'),
                'answer2'       => $request->get('answer2'),
                'answer3'       => $request->get('answer3'),
                'answer4a'      => $request->get('answer4a') ? implode(",", $request->get('answer4a')) : $request->get('answer4a'),
                'answer4b'      => $request->get('answer4b'),
                'nurse_id'      => $request->get('nurse_id'),
                'nurse_name'    => $request->get('nurse_name'),
                'remarks'       => $remarks
            ]
        );

        // change status of session
        $session = Session::find($request->get('session_id'));
        $session->status = $request->get('is_complete');
        $session->save();

        

        // treatment was updated but not completed, no need to send email
        if ($request->get('is_complete') != "2") {
            return back()->with('success', 'Treatment has been updated.');
        }

        // send email to clinic, LU staff, Super Admin
        // appointment details
        $details = DB::table('sessions')
            ->select(
                'sessions.id',
                'sessions.appointment_id',
                'sessions.date',
                'sessions.time_start',
                'sessions.time_end',
                'sessions.status',
                'clinics.name as clinic_name',
                'clinics.address',
                'treatments.name as treatment_name'
            )
            ->join('appointments', 'sessions.appointment_id', '=', 'appointments.id')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->join('treatments', 'appointments.treatment_id', '=', 'treatments.id')
            ->where('sessions.id', $request->get('session_id'))->first();


        //clinic
        $clinic = DB::table('appointments')
            ->select('users.id', 'users.name', 'users.email')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('appointments.id', $details->appointment_id)->get()->toArray();

        // get all Lundbeck Staffs
        $staffs = DB::table('users')
            ->select('email')
            ->where('role_id', "3")   // lundbeck staff
            ->where('receive', "1")
            ->get()->toArray();

        $subject = "Treatment Completed (UAT)";
        $start = "This treatment has been completed.";

        $status = "Completed";

        $appointment_info =  "<html>
                                <head></head>
                                <body>
                                    <table border='0'>
                                        <tr><td>APPOINTMENT DETAILS</td></tr>
                                        <tr><td>Clinic Name: " . $details->clinic_name . "</td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td>TREATMENT DETAILS</td></tr>
                                        <tr><td>Treatment: " . $details->treatment_name . "</td></tr>
                                        <tr><td>Location: " . $details->address . "</td></tr>
                                        <tr><td>Date: " . $details->date . "</td></tr>
                                        <tr><td>Time: " . $details->time_start . " - " . $details->time_end . "</td></tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr><td>Status: " . $status . "</td></tr>
                                    </table>
                                </body>
                            </html>";

        $message = $start . "<br/><br/>" . $appointment_info;

        // send email
        app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $clinic, $staffs);

        return back()->with('success', 'Treatment has been completed.');
    }


    // to retrieve a appointment details
    // in: appointment id
    public function retrieve_appointment(Request $request)
    {
        $appointment = Appointment::where('id', $request->get('id'))->first();

        if ($appointment == null) {
            return back()->withErrors(['message' => 'appointment does not exist']);
        } else {
            return back()->with('appointment', $appointment);
        }
    }

    //redirects to create-appointment view (only if role is clinic)
    public function CreateAppointment(Request $request)
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4 || auth()->user()->role_id == 5) {
            $clinic_id = auth()->user()->clinic_id;

            $treatments = Treatment::where('status', 1)->get();
            // $clinic = Clinic::where('id', auth()->user()->clinic_id)->get()->first();
            $clinics = DB::table('clinics')->where('name', '!=', 'Nurse Agency')->orderBy('name', 'asc')->get();
            $patients = Patient::where('status', 1)->orderBy('name', 'asc')->get(['id', 'name', 'clinic_id']);
            $weekdays_times = MasterTimes::where('category', 'weekdays')->orderBy('times', 'asc')->get(['times_id', 'times']);
            $weekends_times = MasterTimes::where('category', 'weekends')->orderBy('times', 'asc')->get(['times_id', 'times']);

            $last_patient = DB::table('patients')->where('clinic_id', $clinic_id)->orderByRaw('SUBSTR(patient_code, 9, 4) desc')->first();

            return view('appointment_form')->with([
                'clinics' => $clinics,
                'patients' => $patients,
                'treatments' => $treatments,
                'weekdays_times' => $weekdays_times,
                'weekends_times' => $weekends_times,
                'patient_count' => $last_patient == null ? 0 : intval(explode('-', $last_patient->patient_code)[2])
            ]);
        } else {
            return back();
        }
    }

    //redirects to confirm-appointment view
    public function ConfirmAppointment($sessionId)
    {

        if ($sessionId) {
            $session = DB::table('sessions')
                ->select(
                    'sessions.appointment_id as appointment_id',
                    'sessions.id as session_id',
                    'sessions.date as session_date',
                    'sessions.time_start',
                    'sessions.time_end',
                    'patients.name as patient',
                    'treatments.name as treatment',
                    'clinics.name as clinic',
                    'clinics.address as address',
                    'sessions.status',
                    'sessions.token'
                )
                ->join('appointments', 'sessions.appointment_id', '=', 'appointments.id')
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
                ->join('treatments', 'appointments.treatment_id', '=', 'treatments.id')
                // ->join('psp', 'appointments.patient_id', '=', 'psp.patient_id')
                ->where('sessions.status', '!=', -2)
                ->where('sessions.id', $sessionId)->first();

            if ($session) {
                return view('confirm')->with(['session' => $session]);
            }

            return "This is an invalid link. Please contact any Lundbeck Staff and share this url: " . url()->current();
        } else {
            return "This is an invalid link. Please contact any Lundbeck Staff and share this url: " . url()->current();
        }
    }

    // to confirm a appointment details
    public function confirm_appointment(Request $request)
    {
        $data = $request->all();
        $nurse_id = auth()->user()->id;

        $session = Session::find($data['session_id']);
        $session->status = $data['status'];
        $session->approved_by = $nurse_id;
        $session->save();

        //clinic
        $clinic = DB::table('appointments')
            ->select('users.id', 'users.name', 'users.email')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->where('appointments.id', $session->appointment_id)->get()->toArray();

        // get all Lundbeck Staffs
        $staffs = DB::table('users')
            ->select('email')
            ->where('role_id', "3")   // lundbeck staff
            ->where('receive', "1")
            ->get()->toArray();

        if ($data['status'] == "1") {
            $subject = "Appointment - Approved (UAT)";
            $start = "This appointment has been accepted.";
        } else {
            $subject = "Appointment - Rejected (UAT)";
            $start = "This appointment has been rejected.";
        }

        // appointment details
        $details = DB::table('sessions')
            ->select(
                'sessions.id',
                'sessions.date',
                'sessions.time_start',
                'sessions.time_end',
                'sessions.status',
                'clinics.name as clinic_name',
                'clinics.address',
                'treatments.name as treatment_name'
            )
            ->join('appointments', 'sessions.appointment_id', '=', 'appointments.id')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->join('treatments', 'appointments.treatment_id', '=', 'treatments.id')
            ->where('sessions.id', $data['session_id'])->first();

        $appointment_info =  "<html>
                                    <head></head>
                                    <body>
                                        <table border='0'>
                                        <tr><td><u>APPOINTMENT DETAILS</u></td></tr>
                                            <tr><td>Clinic Name: " . $details->clinic_name . "</td></tr>
                                            <tr><td>&nbsp;</td></tr>
                                            <tr><td>Location: " . $details->address . "</td></tr>
                                            <tr><td>Date: " . $details->date . "</td></tr>
                                            <tr><td>Time: " . $details->time_start . " - " . $details->time_end . "</td></tr>
                                            <tr><td>Dosage: " . $details->treatment_name . "</td></tr>
                                            <tr><td>Name of nurse (agency): " . $auth()->user()->name . "</td></tr>
                                            <tr><td>Nurse contact: +65" . $auth()->user()->contact_number . "</td></tr>
                                        </table>
                                    </body>
                                </html>";

        $message = $start . "<br/><br/>" . $appointment_info;

        // send email
        app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $clinic, $staffs);

        return redirect('confirm/' . $data['session_id'])->with('message', 'Appointment has been updated.');
    }
}
