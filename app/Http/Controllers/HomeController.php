<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = date_format(Carbon::now(),"d F Y, l");
        return view('home')->with('date', $date);
    }
    
    // public function index1()
    // {
    //     return view('home1');
    // }

    public function LearnMore()
    {
        $date = date_format(Carbon::now(),"d F Y, l");
        return view('learnmore')->with('date', $date);
    }

    public function efficacious()
    {
        return view('aboutus.efficacious');
    }

    public function fast()
    {
        return view('aboutus.fast');
    }

    public function fusion()
    {
        return view('aboutus.fusion');
    }
   
    public function medication()
    {
        return view('aboutus.medication');
    }

    public function safety()
    {
        return view('aboutus.safety');
    }

    public function sustained()
    {
        return view('aboutus.sustained');
    }

    public function registerhcp()
    {
        return view('auth.registerhcp');
    }

    public function settingsForm()
    {
        return view('settingsForm');
    }

    public function update_settings(Request $request)
    {
        $user = auth()->user();
        
        if($request->get('username')!=null)
        {
            $user->name = $request->get('username');
        }

        if($request->get('password')!= null)
        {
            if(Hash::check($request->get('current_password'), $user->password))
            {
                $validatedData = $request->validate([
                    'current_password' => 'required',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]);
                $user->password = Hash::make($request->get('password'));
            }
            else{
                return back()->withErrors(['current_password'=>'The password you have entered is incorrect']);
            }
        }
        $user->save();
        return redirect()->back()->with('success', "Settings changed successfully");

    }
}
