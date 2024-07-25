<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use Carbon\Carbon;

class TreatmentController extends Controller
{
    // create treatment
    //in :treatment data
    public function create_treatment(Request $request)
    {
        $treatment = new Treatment(request()->all());
        //assuming that no data is nullable. 
        //if any is nullable remove it from the below if status
        if($treatment->name == null || $treatment->no_sessions == null|| $treatment->description == null|| $treatment->frequency_days == null)
        {
            return back()->withErrors(['message'=>'treatment details can not be null']);
        }
        else
        {
            $treatment->status = 1;
            $treatment->created_at = Carbon::now();
            $treatment->save();
            return back()->withErrors(['message'=>'treatment created successfully']);
        }
    }


    // to delete an existing treatment.
    //in :treatment object
    public function delete_treatment(Request $request)
    {
        $treatment = Treatment::where('id', $request->get('id'))->first(); 
        $treatment->delete();
        return back()->withErrors(['message'=>'treatment deleted successfully']);
    }

    // to update a treatment details
    // in: treatment object (to change) and new data
    public function update_treatment(Request $request)
    {
        //this function will only update the feilds that are filled. 
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database APART FROM STATUS

        $treatment = Treatment::where('id', $request->get('id'))->first(); 
        
        if($request->name != null)
        {
            $treatment->name = $request->get('name');
            $treatment->save();
        }
        if($request->no_sessions != null)
        {
            $treatment->no_sessions = $request->get('no_sessions');
            $treatment->save();        
        }
        if($request->description != null)
        {
            $treatment->description = $request->get('description');
            $treatment->save();        
        }
        if($request->frequency_days != null)
        {
            $treatment->frequency_days = $request->get('frequency_days');
            $treatment->save();        
        }  
        if($request->status != true)
        {
            $treatment->status = $request->status;
            $treatment->save();       
        } 
        else{
            $treatment->status = true;
            $treatment->save();       
        }
                    
    }

    // to retrieve a treatment details
    // in: treatment id
    public function retrieve_treatment(Request $request)
    {
        $treatment = Treatment::where('id', $request->get('id'))->first(); 
         
        if($treatment == null)
        {
            return back()->withErrors(['message'=>'treatment does not exist']);
        }
        else{
            return back()->with('treatment',$treatment);
        }
    }
}
