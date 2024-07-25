<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
    // create log
    //in :log data
    public function create_log(Request $request)
    {
        $log = new Log(request()->all());
        //assuming that no data is nullable. 
        //if any is nullable remove it from the below if status
        if($log->user_id == null || $log->type == null || $log->content == null || $log->appointment_id == null)
        {
            return back()->withErrors(['message'=>'log details can not be null']);
        }
        else
        {
            $log->created_at = Carbon::now();
            $log->save();
            return back()->withErrors(['message'=>'log created successfully']);
        }
    }


    // to delete an existing log.
    //in :log object
    public function delete_log(Request $request)
    {
        $log = Log::where('id', $request->get('id'))->first(); 
        if($log != null)
        {
            $log->delete();
            return back()->withErrors(['message'=>'log deleted successfully']);
        }
       else{
            return back()->withErrors(['message'=>'log not found']);
       }
    }



    // to update a log details
    // in: log object (to change) and new data
    public function update_log(Request $request)
    {
        //this function will only update the feilds that are filled. 
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database APART FROM STATUS

        $log = Log::where('id', $request->get('id'))->first(); 
        if($log != null)
        {
            if($request->user_id != null)
            {
                $log->user_id = $request->get('user_id');
                $log->save();
            }
            if($request->type != null)
            {
                $log->type = $request->get('type');
                $log->save();        
            }
            if($request->appointment_id != null)
            {
                $log->appointment_id = $request->get('appointment_id');
                $log->save();        
            }
            if($request->content != null)
            {
                $log->content = $request->get('content');
                $log->save();        
            }  
            $log->updated_at = Carbon::now(); 
        }   
        else {
            return back()->withErrors(['message'=>'log not found']);
        }   
    }

    // to retrieve a log details
    // in: log id
    public function retrieve_log(Request $request)
    {
        $log = Log::where('id', $request->get('id'))->first(); 
         
        if($log == null)
        {
            return back()->withErrors(['message'=>'log does not exist']);
        }
        else{
            return back()->with('log',$log);
        }
    }
}
