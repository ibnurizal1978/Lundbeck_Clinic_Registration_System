<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use Carbon\Carbon;

class ClinicController extends Controller
{
    // create clinic
    //in :clinic data
    public function create_clinic(Request $request)
    {
        $clinic = new Clinic(request()->all());
        //assuming that no data is nullable. 
        //if any is nullable remove it from the below if status
        if($clinic->name == null || $clinic->address == null )
        {
            return back()->withErrors(['message'=>'clinic details can not be null']);
        }
        else
        {
            $clinic->status = false;
            $clinic->created_at = Carbon::now();
            $clinic->save();
            return back()->withErrors(['message'=>'clinic created successfully']);
        }
    }


    // to delete an existing clinic.
    //in :clinic object
    public function delete_clinic(Request $request)
    {
        $clinic = Clinic::where('id', $request->get('id'))->first(); 
        if($clinic != null)
        {
            $clinic->delete();
            return back()->withErrors(['message'=>'clinic deleted successfully']);
        }
       else{
            return back()->withErrors(['message'=>'clinic not found']);
       }
    }



    // to update a clinic details
    // in: clinic object (to change) and new data
    public function update_clinic(Request $request)
    {
        //this function will only update the feilds that are filled. 
        //e.g. in the form we have four feilds to update. if only two are filled thee two information will be updated
        //empty feilds will not update the database APART FROM STATUS

        $clinic = Clinic::where('id', $request->get('id'))->first(); 
        if($clinic != null)
        {
            if($request->name != null)
            {
                $clinic->name = $request->get('name');
                $clinic->save();
            }
            if($request->address != null)
            {
                $clinic->address = $request->get('address');
                $clinic->save();        
            }
            if($request->status != true)
            {
                $clinic->status = $request->status;
                $clinic->save();       
            } 
            else{
                $clinic->status = true;
                $clinic->save();       
            }
            $clinic->updated_at = Carbon::now(); 
        }   
        else {
            return back()->withErrors(['message'=>'clinic not found']);
        }   
    }

    // to retrieve a clinic details
    // in: clinic id
    public function retrieve_clinic(Request $request)
    {
        $clinic = Clinic::where('id', $request->get('id'))->first(); 
         
        if($clinic == null)
        {
            return back()->withErrors(['message'=>'clinic does not exist']);
        }
        else{
            return back()->with('clinic',$clinic);
        }
    }
}
