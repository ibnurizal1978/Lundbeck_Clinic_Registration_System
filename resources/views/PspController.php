<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psp;
use App\Models\Patient;
use App\Models\Clinic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidIC;

class PspController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // create psp CRUD
    //in :psp data
    public function create_psp(Request $request)
    {
        $psp = new Psp(request()->all());
        //assuming that answers are nullable!
        if ($psp->patient_id == null || $psp->code == null) {
            return back()->withErrors(['message' => 'psp details can not be null']);
        } else {
            $psp->created_at = Carbon::now();
            $psp->save();
            return back()->withErrors(['message' => 'psp created successfully']);
        }
    }


    //form response. creates PSP record
    public function createPsp(Request $request)
    {
        //validate fields
        $validated = $request->validate([
            'clinic_id'         => 'required',
            'name'              => 'required|unique:patients,name',
            'code'              => 'required',
            'fl_nric'           => 'required',
            'cl_nric'           => 'required',
            'l4_nric'           => ['required', new ValidIC($request->get('patient_status'), $request->get('fl_nric'), $request->get('cl_nric'), $request->get('l4_nric'))],
        ],
        [
            'fl_nric.required' => 'The nric field is required.',
            'cl_nric.required' => 'The nric field is required.',
            'l4_nric.required' => 'The nric field is required.'
        ]);

        // save patient details ($isPSP = true)
        $request->nric = $request->get('fl_nric') . $request->get('cl_nric') . $request->get('l4_nric');
        $request->services_type_id = 2; //RZL
        $patient_id = app('App\Http\Controllers\PatientController')->create_patient($request, true);

        //input data
        $psp = new Psp();
        $psp->patient_id = $patient_id;
        $psp->code = $request->code;
        $psp->answer1 = $psp->answer2 = $psp->answer3 = "";
        $psp->save();

        // get all Lundbeck Staffs
        $staffs = DB::table('users')
            ->select('.email')
            ->where('role_id', "3")   // lundbeck staff
            ->orWhere('role_id', "5") // salesperson
            ->where('receive', "1")
            ->where('status', "1")->get()->toArray();

        $subject = "New Patient Enrolled Onto Power On Treatment Plan";
        $start = "New Patient Enrolled Onto Power On Treatment Plan.";

        $clinic = DB::table('clinics')->where('id', $request->get('clinic_id'))->select(['name', 'psp_code', 'address'])->first();

        $appointment_info = "<html>
                                <head></head>
                                <body>
                                    <p>A new patient has been enrolled onto power on treatment plan.</p>
                                    <br/><br/>
                                    <table border='0'>
                                        <tr><td>Clinic Name: " . $clinic->name . "</td></tr>
                                        <tr><td>Location: " . $clinic->address . "</td></tr>
                                    </table>
                                </body>
                            </html>";

        $message = $start . "<br/><br/>" . $appointment_info;

        // send email
        app('App\Http\Controllers\MailerController')->sendemail($subject, $message, $staffs);

        // send sms
        if (env('SEND_SMS')) {
            // send sms LU Staff (Darryl)
            app('App\Http\Controllers\TwilioSMSController')->sendSMSCC("A new patient has been enrolled onto power on treatment plan by [" . $clinic->psp_code . "][" . $clinic->name . "]");
        }

        return redirect('home')->with('message', 'Record Created Successfully');
    }

    // to delete an existing psp.
    //in :psp object
    public function delete_psp(Request $request)
    {
        $psp = Psp::where('id', $request->get('id'))->first();
        if ($psp != null) {
            $psp->delete();
            return back()->withErrors(['message' => 'psp deleted successfully']);
        } else {
            return back()->withErrors(['message' => 'psp not found']);
        }
    }



    // to update a psp details
    // in: psp object (to change) and new data
    public function update_psp(Request $request)
    {
        //this function will only update the feilds that are filled.
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database

        $psp = Psp::where('id', $request->get('id'))->first();
        if ($psp != null) {
            if ($request->patient_id != null) {
                $psp->patient_id = $request->get('patient_id');
                $psp->save();
            }
            if ($request->code != null) {
                $psp->code = $request->get('code');
                $psp->save();
            }
            if ($request->answer1 != null) {
                $psp->answer1 = $request->get('answer1');
                $psp->save();
            }
            if ($request->answer2 != null) {
                $psp->answer2 = $request->get('answer2');
                $psp->save();
            }
            if ($request->answer3 != null) {
                $psp->answer3 = $request->get('answer3');
                $psp->save();
            }
            $psp->updated_at = Carbon::now();
            return back();
        } else {
            return back()->withErrors(['message' => 'psp not found']);
        }
    }

    // to retrieve a psp details
    // in: psp id
    public function retrieve_psp(Request $request)
    {
        $psp =  Psp::where('id', $request->get('id'))->first();

        if ($psp == null) {
            return back()->withErrors(['message' => 'psp record does not exist']);
        } else {
            return back()->with('psp', $psp);
        }
    }

    public function RegisterPspForm(Request $request)
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4) {
            $clinic_id = auth()->user()->clinic_id;

            $clinics = DB::table('clinics')->where('name', '!=', 'Nurse Agency')->orderBy('name', 'asc')->get();
            // $clinic_count = DB::table('patients')->where('psp_reg', 1)->where('clinic_id', $clinic_id)->count();
            $last_patient = DB::table('patients')->where('clinic_id', $clinic_id)->orderByRaw('SUBSTR(patient_code, 9, 4) desc')->first();

            return view('powerOnPlan')->with([
                'clinic_id' => auth()->user()->clinic_id,
                'clinics' => $clinics,
                // 'clinic_count' => $clinic_count,
                'count' => $last_patient == null ? 0 : intval(explode('-', $last_patient->patient_code)[2])
            ]);
        } else {
            return back();
        }
    }
}
