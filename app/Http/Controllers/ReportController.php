<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PspRemark;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{

    public function patientSummary()
    {
        $where = '';
        if (auth()->user()->role_id == "1") {
            $where = 'WHERE b.clinic_id = ' . auth()->user()->clinic_id;
        }
        $data = DB::select(
            DB::raw(
                "SELECT patientid, patient_code, name, services_type_id, patient_created_at, COALESCE(MAX(IF(rn = 1, updated_at, NULL)), 'x') AS `one`, COALESCE(MAX(IF(rn = 2, updated_at, NULL)), 'x') AS `two`, COALESCE(MAX(IF(rn = 3, updated_at, NULL)), 'x') AS `three`, COALESCE(MAX(IF(rn = 4, updated_at, NULL)), 'x') AS `four`
                FROM ( SELECT b.id as patientid, b.patient_code, b.name, b.services_type_id, date_format(a.updated_at, '%d-%m-%Y') as updated_at, date_format(b.created_at, '%d %M %Y %H:%i:%s') as patient_created_at, ROW_NUMBER() OVER (PARTITION BY patient_id ORDER BY a.updated_at) AS rn FROM patients b LEFT JOIN psp_remarks a ON a.patient_id = b.id
                " . $where . ") AS t
                GROUP BY patientid
                ORDER BY patient_code"
            )
        );
        return view('reports/patientSummary', ['data' => $data]);
    }

    public function patientSummaryFilter(Request $r)
    {
        $where = '';
        if (auth()->user()->role_id == "1") {
            $where = 'WHERE b.clinic_id = ' . auth()->user()->clinic_id;
        }
        
        if($r->filter_by == 0) { $services_type_id = 'IN (0,1,2)'; }
        if($r->filter_by == 1) { $services_type_id = 'IN (0,1)'; }
        if($r->filter_by == 2) { $services_type_id = 'IN (2)'; }        
    
        $data = DB::select(
            DB::raw(
                "SELECT patientid, patient_code, name, services_type_id, patient_created_at, COALESCE(MAX(IF(rn = 1, updated_at, NULL)), 'x') AS `one`, COALESCE(MAX(IF(rn = 2, updated_at, NULL)), 'x') AS `two`, COALESCE(MAX(IF(rn = 3, updated_at, NULL)), 'x') AS `three`, COALESCE(MAX(IF(rn = 4, updated_at, NULL)), 'x') AS `four`
                FROM ( SELECT b.id as patientid, b.patient_code, b.name, b.services_type_id, date_format(a.updated_at, '%d-%m-%Y') as updated_at, date_format(b.created_at, '%d %M %Y %H:%i:%s') as patient_created_at, ROW_NUMBER() OVER (PARTITION BY patient_id ORDER BY a.updated_at) AS rn FROM patients b LEFT JOIN psp_remarks a ON a.patient_id = b.id
                " . $where . " AND services_type_id  ".$services_type_id. ") AS t
                GROUP BY patientid
                ORDER BY patient_code"
            )
        );
        return view('reports/patientSummary', ['data' => $data, 'filter' => $r->filter_by]);

    }

}
