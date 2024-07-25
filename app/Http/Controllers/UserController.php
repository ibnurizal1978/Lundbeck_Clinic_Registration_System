<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class UserController extends Controller
{
    public function index()
    {   if(auth()->user()->role_id == 4)
        {
            $users =  User::where('role_id', '<>', 4)->get();
            $pending_users = User::where('status', 0)->where('role_id', '<>', 4)->get();
            return view('manageUsers')->with(['users'=>$users, 'pending_users'=>$pending_users, 'users_opt'=>"Filter by role", 'pending_opt'=>"Filter by role"]);
        }
        else{
            return redirect('/home');
        }
    }
    public function deleteUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->delete();
        return back()->with(['message','deleted successfully']);
    }
    public function disableUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->status = 0;
        $user->save();
        return back()->with(['message','User disabled successfully']);
    }
    public function enableUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->status = 1;
        $user->save();
        return back()->with(['message','User enabled successfully']);
    }
    public function toNotifyUser(Request $request) {
        $user = User::findOrFail($request->id);
        $user->receive = $request->notify;
        $user->save();
        return back()->with(['message','User enabled successfully']);
    }
    public function searchUser(Request $request){
        // $user = User::findOrFail($request->id);
        return back()->with(['us','deleted successfully']);
    }
}
