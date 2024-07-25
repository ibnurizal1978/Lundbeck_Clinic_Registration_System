<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Clinic;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidSGContactNumber;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'role' => ['required'],
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'contactnumber' => ['required', 'string', 'size:8', new ValidSGContactNumber],
            'clinic' => ['required'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
			'password_confirmation' => ['required'],
			'consent' => ['accepted'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Validator::make($data, [
		// 	'role_opt' => 'required',
		// 	'name' => 'required|string|max:255',
		// 	'email' => 'required|email|unique:users,email',
		// 	'contactnumber' => 'required',
		// 	'password' => 'required|min:6|confirmed',
		// 	'password_confirmation' => 'required|confirmed|same:password',
		// 	'consent' => 'accepted',
		// ]);
        if($data['role'] == 3) //lundbeck staff
        {
            $clinic_id= 0;
        }
        else{
            $clinic_id = $data['clinic'];
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact_number' => $data['contactnumber'],
            // 'comm_mode' => $data['modeofcomm'],
            'clinic_id' => $clinic_id,
            'comm_mode' => 'email',
            'receive' => isset($data['receive']) ? true : false,
            'status' => '0',
            'role_id' => $data['role'],
        ]);
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $clinics = DB::table('clinics')->orderBy('name', 'asc')->get();
        return view('auth.register', compact('clinics'));
    }
}
