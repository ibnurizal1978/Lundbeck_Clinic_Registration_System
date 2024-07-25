<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Clinic;
use  URL;
use Session;

class AuthController extends Controller
{


	/*
	 * Register new user
	*/
	public function signup(Request $request) {
		$validatedData = $request->validate([
			'role_opt' => 'required',
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:users,email',
			'contactnumber' => 'required',
			'password' => 'required|min:10|confirmed',
			'password_confirmation' => 'required|confirmed|same:password',
			'consent' => 'accepted',
		]);
		// if($request->has('consent')){
        //     dd("has");
        // }else{
        //     return back()->withErrors(['consent'=>'This field is required']);
        // }

		$validatedData['password'] = Hash::make($validatedData['password']);

		if(User::create($validatedData)) {
			return response()->json(null, 201);
		}

		return response()->json(null, 404);
	}

	/*
	 * Generate sanctum token on successful login
	*/
	public function login(Request $request) {
		$request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		$user = User::where('email', $request->email)->first();

		if (! $user || ! Hash::check($request->password, $user->password)) {
			throw ValidationException::withMessages([
				'email' => ['The provided credentials are incorrect.'],
			]);
		}

		return response()->json([
			'user' => $user,
			'access_token' => $user->createToken($request->email)->plainTextToken
		], 200);
	}


	/*
	 * Revoke token; only remove token that is used to perform logout (i.e. will not revoke all tokens)
	*/
	public function logout(Request $request) {

		// Revoke the token that was used to authenticate the current request
		$request->user()->currentAccessToken()->delete();
		//$request->user->tokens()->delete(); // use this to revoke all tokens (logout from all devices)
		return response()->json(null, 200);
	}


	/*
	 * Get authenticated user details
	*/
	public function getAuthenticatedUser(Request $request) {
		return $request->user();
	}


	/*public function sendPasswordResetLinkEmail(Request $request) {
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink(
			$request->only('email')
		);

		if($status === Password::RESET_LINK_SENT) {
			// return response()->json(['message' => __($status)], 200);
			return redirect('password/reset?success');
		} else {
			// throw ValidationException::withMessages([
			// 	'email' => __($status)
			// ]);
			// return redirect('password/reset?failed');
			$prev = url()->previous();

			echo "Error has been encountered. Please click <a href='".$prev."'>here</a> to try again.";
		}
	}*/

	public function sendPasswordResetLinkEmail(Request $request) {
	
		if($request->validate(['email' => 'required|email']))
		{

			/*DB::enableQueryLog();
			$staffs = DB::table('users')
            ->select('email')
            ->whereIn('role_id', [3,4,5])   // lundbeck staff
            ->where('receive', "1")
			->where('status', 1)
			->get();
			dd(DB::getQueryLog());*/

			$permitted_chars = 'abcdefghijklmnpqrstuvwxyz123456789';
			$token = substr(str_shuffle($permitted_chars), 0, 25);
			$new_token = Hash::make($token);
			$url = URL::to('/')."/password/reset/".$token;
			$subject = 'Password Reset';
			$message = "<html>
							<head></head>
							<body>
							<h3>Hello!</h3>
							<p color='#7c7d7c'>You are receiving this email because we received a password reset request for your account</p>
							<p style='text-align:center'><br/><a href=".$url." style='text-decoration:none; background-color:#565ccc; color:#fff;padding-top:10px;padding-bottom:10px; padding-left:20px; padding-right:20px'>Reset Password</a><br/></p>
							<br/><p color='#7c7d7c'>If you did not request a password reset, no further action is required.</p>
							<p color='#7c7d7c'>Regards,<br/>Laravel</p>
							<hr/>
							<p style='font-size:8pt'>If you are having trouble clicking the \"Reset Password button\", copy and paste the URL below into your web browser:
							<br/>
							<a href=".$url.">".$url."</a></p>
							</body>
						</html>";
			$status = Password::sendResetLink(
				$request->only('email')
			);

			$tbl = DB::table('password_resets')->insert([
				'email' => $request->email,
				'token' => $new_token,
				'created_at' => now()
			]);
			
			app('App\Http\Controllers\MailerController')->sendemailSingle($subject, $message, $request->email);
			
			return redirect('password/reset?success');
		}
	}

	public function resetPassword(Request $request) {
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8|confirmed',
		]);

		$check = DB::table('users')->where('email', $request->email)->get();
		if(count($check) == 0)
		{
			$prev = url()->previous();
			echo "Email did not found. Please click <a href='".$prev."'>here</a> to try again.";
		}else{

			$db = DB::table('users')->where('email', $request->email)
				->update([
					'password' => Hash::make($request->password)
				]);

			if($db) {
				return redirect('/login?success');
			} else {
				$prev = url()->previous();
				echo "Error has been encountered. Please click <a href='".$prev."'>here</a> to try again.";
			}
		}
		
	}
	

	/*public function resetPassword(Request $request) {
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8|confirmed',
			// 'password_confirmation' => 'required|confirmed|same:password',
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) use ($request) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if($status == Password::PASSWORD_RESET) {
			// return response()->json(['message' => __($status)], 200);
			return redirect('/login?success');
		} else {
			// throw ValidationException::withMessages([
			// 	'email' => __($status)
			// ]);
			$prev = url()->previous();

			echo "Error has been encountered. Please click <a href='".$prev."'>here</a> to try again.";
		}
	}*/
}
