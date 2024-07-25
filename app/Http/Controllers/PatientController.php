<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class PatientController extends Controller
{
    public function index()
    {
        if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
        {
            $patients =  DB::table('patients')->leftJoin('clinics', function ($join) {
                $join->on('patients.clinic_id', '=', 'clinics.id');
            })->leftJoin('psp', function ($join) {
                $join->on('patients.id', '=', 'psp.patient_id');
            })->get([
                'patients.id', 'patients.services_type_id', 'patients.name', 'patients.nric', 'patients.clinic_id', 'clinics.name as clinic_name', 'patients.psp_reg',
                'psp.code as patient_code', 'patient_code as patient_code2', 'patients.status', 'patients.created_at', 'patients.updated_at'
            ]);

            return view('managePatients')->with(['patients'=>$patients]);
        }
        else{
            return redirect('/home');
        }
    }

    // create non psp patient
    //in :patient data: name, nric
    public function create_patient(Request $request, $isPSP = false)
    {
        $user = auth()->user();

        $patient = new Patient();
        $patient->patient_code = $request->code;
        $patient->name = $request->name;
        $patient->nric = $request->nric;
        $patient->clinic_id = isset($request->location) == null ? $request->clinic_id : $request->location;
        $patient->psp_reg = $isPSP;
        $patient->status = 1;
        //line 48 added by Rizal, from slide 22
        $patient->services_type_id = $request->services_type_id;
        $patient->save();

        return $patient->id;
    }

    // create non psp patient
    //in :patient data: name, nric
    public function create_psp_patient(Request $request)
    {
        $patient = new Patient(request()->all());
        if($patient->name == null || $patient->nric == null)
        {
            return redirect()->back()->with('message', 'patient can not be created');
        }
        else{

            //only save last four digits of nric
            $stars = "";
            for($i=0; $i<strlen($patient->nric)-4; $i++)
            {
                $stars .= "*";
            }
            $patient->nric= substr($patient->nric, -4);
            $patient->nric=  $stars.$patient->nric;

            $patient->psp_reg = true;
            $patient->status = 1;
            $patient->name = $request->name;
            $patient->clinic_id = $request->get("clinic_id");
            $patient->save();
            $request->patient_id = $patient->id;
        }
        return;
    }

    // create psp patient
    //in :patient data: name, nric
    // public function create_psp_patient(Request $request)
    // {
    //     $patient = new Patient(request()->all());
    //     if($patient->name == null || $patient->nric == null)
    //     {
    //         return back()->withErrors(['message'=>'Patient name and nric can not be null']);
    //     }
    //     else{
    //         $patient->psp_reg = true;
    //         $patient->status = 1;
    //         $patient->save();
    //         return back()->withErrors(['message'=>'PSP patient created successfully']);
    //     }
    // }

    // to register an existing patient in psp program
    //in :patient object
    public function register_psp(Request $request)
    {
        $patient = Patient::where('id', $request->get('id'))->first();
        $patient->psp_reg = true;
        $patient->save();
    }

    // to delete an existing patient.
    //in :patient object
    public function delete_patient(Request $request)
    {
        $patient = Patient::where('id', $request->get('id'))->first();
        $patient->delete();
    }

    // to update a patient details
    // in: patient object (to change) and new data
    public function update_patient(Request $request)
    {
        $patient = Patient::where('id', $request->get('id'))->first();

        if($request->name != null)
        {
            $patient->name = $request->get('name');
            $patient->save();
        }
        if($request->nric != null)
        {
            $patient->nric = $request->get('nric');
            $patient->save();
        }
        $patient->updated_at = Carbon::now();
    }

    // to retrieve a patient details
    // in: patient id
    public function retrieve_patient(Request $request)
    {
        $patient = Patient::where('id', $request->get('id'))->first();

        if($patient == null)
        {
            return back()->withErrors(['message'=>'patient does not exist']);
        }
        else{
            return back()->with('patient',$patient);
        }
    }

    public function generate_patient_code()
    {
        $patients = Patient::where('patient_code', '')->orderBy('created_at', 'asc')->get();
        foreach ($patients as $patient) {
            $max_patient_clinic = DB::table('patients')
                ->join('clinics', 'patients.clinic_id', '=', 'clinics.id')
                ->where('patients.clinic_id', $patient->clinic_id)
                ->orderBy('patient_code', 'desc')
                ->select(['clinics.psp_code', 'patients.patient_code'])
                ->first();
            $last_int = 0;
            if ($max_patient_clinic->patient_code != '') {
                $str = explode("-", $max_patient_clinic->patient_code);
                $last_int = intval($str[2]);
            }
            $exist_patient = DB::table('psp')->where('patient_id', $patient->id)->first();
            $patient->patient_code = ($exist_patient != null ? $exist_patient->code : $max_patient_clinic->psp_code . '-' . sprintf("%04s", $last_int + 1));
            $patient->save();
        }

        return redirect('/home');
    }

    public function get_patient_count(Request $request)
    {
        $max_patient_clinic = DB::table('patients')
            ->where('clinic_id', $request->clinic_id)
            ->orderBy('patient_code', 'desc')
            ->select('patient_code')
            ->first();
        $last_int = 0;
        if ($max_patient_clinic != null) {
            $str = explode("-", $max_patient_clinic->patient_code);
            $last_int = intval($str[2]);
        }

        return $last_int;
    }

    /* added by Rizal for slide 41 */
    public function reportFilter(Request $r)
    {
        if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
        {
            /*** added by Rizal for slide 41 */
            if($r->filter_by == 0) { $services_type_id = '0,1,2'; }
            if($r->filter_by == 1) { $services_type_id = '1,0'; }
            if($r->filter_by == 2) { $services_type_id = '2'; }      

            DB::enableQueryLog();
            if($r->filter_by > 0)
            {
            $patients =  DB::table('patients')
            ->whereIn('services_type_id', [$services_type_id])
            ->leftJoin('clinics', function ($join) {
                $join->on('patients.clinic_id', '=', 'clinics.id');
            })->leftJoin('psp', function ($join) {
                $join->on('patients.id', '=', 'psp.patient_id');
            })->get([
                'patients.id', 'patients.services_type_id', 'patients.name', 'patients.nric', 'patients.clinic_id', 'clinics.name as clinic_name', 'patients.psp_reg',
                'psp.code as patient_code', 'patient_code as patient_code2', 'patients.status', 'patients.created_at', 'patients.updated_at'
            ]);
            /*** end added by Rizal */
            }else{
                $patients =  DB::table('patients')
                ->leftJoin('clinics', function ($join) {
                    $join->on('patients.clinic_id', '=', 'clinics.id');
                })->leftJoin('psp', function ($join) {
                    $join->on('patients.id', '=', 'psp.patient_id');
                })->get([
                    'patients.id', 'patients.services_type_id', 'patients.name', 'patients.nric', 'patients.clinic_id', 'clinics.name as clinic_name', 'patients.psp_reg',
                    'psp.code as patient_code', 'patient_code as patient_code2', 'patients.status', 'patients.created_at', 'patients.updated_at'
                ]);
            }
            //dd(DB::getQueryLog());

            return view('managePatients')->with(['patients'=>$patients, 'filter' => $r->filter_by]);
        }
        else{
            return redirect('/home');
        }
    }
    /* end added by Rizal */
}
