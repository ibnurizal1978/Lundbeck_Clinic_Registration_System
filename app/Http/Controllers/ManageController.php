<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class ManageController extends Controller
{
    public function index()
    {   
        // if(auth()->user()->role_id == 4)
        // {
        //     $users = DB::table('users')->where('role_id', '<>', 4)->get();
        //     $pending_users = User::where('status', 0)->where('role_id', '<>', 4)->get();
        //     return view('manageUsers')->with(['users'=>$users, 'pending_users'=>$pending_users, 'users_opt'=>"Filter by role", 'pending_opt'=>"Filter by role"]);
        // }
        // else{
        //     return redirect('/home');
        // }
    }
}
