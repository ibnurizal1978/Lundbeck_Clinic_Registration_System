<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterTimes;

class CalendarController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $current_date = date("m-d-Y");
        // $current_date = '03-08-2023';

        $sessions = DB::table('sessions');

        // if clinic, get appointments under the clinic. otherwise, get all
        if ($user->role_id == "1") {
            $sessions = $sessions->join('appointments', function ($join) use ($user) {
                $join->on('sessions.appointment_id', '=', 'appointments.id')
                    ->where('appointments.clinic_id', '=', $user->clinic_id);
            });
        } else {
            $sessions = $sessions->join('appointments', function ($join) use ($user) {
                $join->on('sessions.appointment_id', '=', 'appointments.id');
            });
        }

        $sessions = $sessions->join('clinics', function ($join) {
            $join->on('appointments.clinic_id', '=', 'clinics.id');
        });

        $sessions = $sessions->join('patients', function ($join) {
            $join->on('appointments.patient_id', '=', 'patients.id');
        })->leftJoin('psp', function ($join) {
            $join->on('appointments.patient_id', '=', 'psp.patient_id');
        })->leftJoin('psp_remarks', function ($join) {
            $join->on('sessions.id', '=', 'psp_remarks.session_id');
        });

        // exclude cancelled appointments (status = -2)
        $sessions = $sessions->where('sessions.status', '!=', -2);
        
        // for nurse, retrieve only non-cancelled and pending sessions
        /***if ($user->role_id == "2") {
            $sessions = $sessions->where('sessions.status', '!=', -1)->where('sessions.status', '!=', 0);
        }***/

        // if date is given, get all appointments for that date
        // if ($user->role_id != "3") {
        $sessions = $sessions->where('sessions.date', $current_date);
        // } else {
        //     $sessions = $sessions->where('sessions.date', '>=', $current_date);
        // }
        $sessions = $sessions->orderBy('date', 'asc')->orderBy('time_start', 'asc')->get([
            'sessions.*', 'sessions.id as session_id', 'sessions.status AS session_status',
            'appointments.clinic_id', 'appointments.user_id', 'appointments.treatment_id',
            'patients.id as patient_id', 'patients.name', 'patients.nric', 'patients.psp_reg',
            'psp.code as patient_code', 'clinics.name as clinic_name', 'clinics.medical_centre as medical_centre', 'clinics.unit as unit',
            'psp_remarks.answer1', 'psp_remarks.answer2', 'psp_remarks.answer3', 'psp_remarks.answer4a', 'psp_remarks.answer4b',
            'psp_remarks.remarks', 'psp_remarks.nurse_id', 'psp_remarks.nurse_name'
        ]);

        $weekdays_times = MasterTimes::where('category', 'weekdays')->orderBy('times', 'asc')->get(['times_id', 'times']);
        $weekends_times = MasterTimes::where('category', 'weekends')->orderBy('times', 'asc')->get(['times_id', 'times']);

        return view('calendarview')->with(['todays' => $sessions, 'weekdays_times' => $weekdays_times, 'weekends_times' => $weekends_times]);
    }

    public function calendarEvents(Request $request)
    {

        switch ($request->type) {
            case 'create':
                $event = CrudEvents::create([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'edit':
                $event = CrudEvents::find($request->id)->update([
                    'event_name' => $request->event_name,
                    'event_start' => $request->event_start,
                    'event_end' => $request->event_end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = CrudEvents::find($request->id)->delete();

                return response()->json($event);
                break;

            case 'retrieve':
                $user = auth()->user();
                $current_date = $request->date;
                $current_month = $request->month;
                $current_year = $request->year;

                $sessions = DB::table('sessions');

                // if clinic, get appointments under the clinic. otherwise, get all
                /*** added by Rizal for slide 27 -> add || $user->role_id == "2" */
                if ($user->role_id == "1" || $user->role_id == "2") {
                /*** end added by Rizal */
                    $sessions = $sessions->join('appointments', function ($join) use ($user) {
                        $join->on('sessions.appointment_id', '=', 'appointments.id');
                            //->where('appointments.clinic_id', '=', $user->clinic_id);
                    });
                } else {
                    $sessions = $sessions->join('appointments', function ($join) use ($user) {
                        $join->on('sessions.appointment_id', '=', 'appointments.id');
                    });
                }

                $sessions = $sessions->join('clinics', function ($join) use ($user) {
                    $join->on('appointments.clinic_id', '=', 'clinics.id');
                });

                $sessions = $sessions->join('patients', function ($join) {
                    $join->on('appointments.patient_id', '=', 'patients.id');
                })->leftJoin('psp', function ($join) {
                    $join->on('appointments.patient_id', '=', 'psp.patient_id');
                })->leftJoin('psp_remarks', function ($join) {
                    $join->on('sessions.id', '=', 'psp_remarks.session_id');
                });

                // if date is given, get all appointments for that date
                if ($current_date == '') {
                    $sessions = $sessions->where('sessions.date', 'like', $current_month . '-%-' . $current_year);
                } else {
                    $sessions = $sessions->where('sessions.date', $current_date);
                }

                // exclude cancelled appointments (status = -2)
                $sessions = $sessions->where('sessions.status', '!=', -2);

                // for nurse, retrieve only non-cancelled and pending sessions
                /*** added by Rizal for slide 27, I commented this
                if ($user->role_id == "2") {
                    $sessions = $sessions->where('sessions.status', '!=', -1)->where('sessions.status', '!=', 0);
                }
                end added by Rizal ***/

                $sessions = $sessions->orderBy('date', 'asc')->orderBy('time_start', 'asc')->get([
                    'sessions.*', 'sessions.id as session_id', 'sessions.status AS session_status', 'appointments.clinic_id',
                    'appointments.user_id', 'appointments.treatment_id', 'patients.id as patient_id', 'patients.patient_code as patient_code',
                    'patients.name', 'patients.nric', 'patients.psp_reg', 'clinics.name as clinic_name',
                    'clinics.medical_centre as medical_centre', 'clinics.unit as unit', 'psp_remarks.answer1', 'psp_remarks.answer2',
                    'psp_remarks.answer3', 'psp_remarks.answer4a', 'psp_remarks.answer4b', 'psp_remarks.remarks', 'psp_remarks.nurse_id',
                    'psp_remarks.nurse_name'
                ]);

                return response()->json($sessions);
                break;

            case 'retrieve_lite':
                $user = auth()->user();
                $current_date = $request->date;
                $current_month = $request->month;
                $current_year = $request->year;

                $sessions = DB::table('sessions');

                // if clinic, get appointments under the clinic. otherwise, get all
                $sessions = $sessions->join('appointments', function ($join) use ($user) {
                    $join->on('sessions.appointment_id', '=', 'appointments.id');
                });

                $sessions = $sessions->join('patients', function ($join) {
                    $join->on('appointments.patient_id', '=', 'patients.id');
                })->leftJoin('psp', function ($join) {
                    $join->on('appointments.patient_id', '=', 'psp.patient_id');
                })->leftJoin('psp_remarks', function ($join) {
                    $join->on('sessions.id', '=', 'psp_remarks.session_id');
                });

                // if date is given, get all appointments for that date
                if ($current_date == '') {
                    $sessions = $sessions->where('sessions.date', 'like', $current_month . '-%-' . $current_year);
                } else {
                    $sessions = $sessions->where('sessions.date', $current_date);
                }

                // exclude cancelled appointments (status = -2)
                $sessions = $sessions->where('sessions.status', '!=', -2);

                // for nurse, retrieve only non-cancelled and pending sessions
                /*if ($user->role_id == "2") {
                    $sessions = $sessions->where('sessions.status', '!=', -1)->where('sessions.status', '!=', 0);
                }*/

                // return $sessions->toSql();
                $sessions = $sessions->orderBy('date', 'asc')->orderBy('time_start', 'asc')->get([
                    'sessions.*', 'sessions.status AS session_status', 'appointments.*',
                    'patients.*', 'psp.code as patient_code', 'psp_remarks.*'
                ]);

                return response()->json($sessions);
                break;

            default:
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
