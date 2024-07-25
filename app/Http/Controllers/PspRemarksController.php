<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PspRemark;
use Carbon\Carbon;

class PspRemarksController extends Controller
{
    // create _remark
    //in :_remark data
    public function create_remark(Request $request)
    {
        $remark = new PspRemark(request()->all());
        //assuming that answers are nullable!
        if($remark->patient_id == null || $remark->session_id == null)
        {
            return back()->withErrors(['message'=>'session id and patient id can not be null']);
        }
        else
        {
            $remark->created_at = Carbon::now();
            $remark->save();
            return back()->withErrors(['message'=>'remark created successfully']);
        }
    }


    // to delete an existing remark.
    //in :remark id
    public function delete_remark(Request $request)
    {
        $remark = PspRemark::where('id', $request->get('id'))->first(); 
        if($remark != null)
        {
            $remark->delete();
            return back()->withErrors(['message'=>'Record deleted successfully']);
        }
       else{
            return back()->withErrors(['message'=>'Record not found']);
       }
    }



    // to update a remark details
    // in: remark object (to change) and new data
    public function update_remark(Request $request)
    {
        //this function will only update the feilds that are filled. 
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database

        $remark = PspRemark::where('id', $request->get('id'))->first(); 
        if($remark != null)
        {
            if($request->patient_id != null)
            {
                $remark->patient_id = $request->get('patient_id');
                $remark->save();
            }
            if($request->session_id != null)
            {
                $remark->session_id = $request->get('session_id');
                $remark->save();        
            }
            if($request->answer1 != null)
            {
                $remark->answer1 = $request->get('answer1');
                $remark->save();        
            }
            if($request->answer2 != null)
            {
                $remark->answer2 = $request->get('answer2');
                $remark->save();        
            }
            if($request->answer3 != null)
            {
                $remark->answer3 = $request->get('answer3');
                $remark->save();        
            }
            $remark->updated_at = Carbon::now(); 
            return back();
        }   
        else {
            return back()->withErrors(['message'=>'record not found']);
        }   
    }

    // to retrieve a remark details
    // in: remark id
    public function retrieve_remark(Request $request)
    {
        $remark =  PspRemark::where('id', $request->get('id'))->first(); 
         
        if($remark == null)
        {
            return back()->withErrors(['message'=>'record does not exist']);
        }
        else{
            return back()->with('remark',$remark);
        }
    }
}
