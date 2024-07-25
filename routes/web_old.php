<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClinicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();

// needs authentication
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('RegisterPSP', [App\Http\Controllers\PspController::class, 'RegisterPspForm'])->name('RegisterPSP');
    Route::post('createPSP', [App\Http\Controllers\PspController::class, 'createPsp'])->name('createPSP');

    Route::post('make_appointment', [App\Http\Controllers\AppointmentController::class, 'register'])->name('make_appointment');
    Route::get('CreateAppointment', [App\Http\Controllers\AppointmentController::class, 'CreateAppointment'])->name('CreateAppointment');
    Route::get('learnmore', [App\Http\Controllers\HomeController::class, 'LearnMore'])->name('learnmore');
    Route::post('update_remarks', [App\Http\Controllers\AppointmentController::class, 'UpdateRemarks'])->name('update_remarks');
    Route::post('update_session', [App\Http\Controllers\SessionController::class, 'UpdateSession'])->name('update_session'); //for clinic to update session
    Route::view('/redirect_page', 'redirect_page');

    Route::get('/calendarview', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendarview');
    Route::post('/calendar-crud-ajax', [App\Http\Controllers\CalendarController::class, 'calendarEvents']);

    Route::get('/aboutus/efficacious', [App\Http\Controllers\HomeController::class, 'efficacious'])->name('efficacious');
    Route::get('/aboutus/fast', [App\Http\Controllers\HomeController::class, 'fast'])->name('fast');
    Route::get('/aboutus/fusion', [App\Http\Controllers\HomeController::class, 'fusion'])->name('fusion');
    Route::get('/aboutus/medication', [App\Http\Controllers\HomeController::class, 'medication'])->name('medication');
    Route::get('/aboutus/safety', [App\Http\Controllers\HomeController::class, 'safety'])->name('safety');
    Route::get('/aboutus/sustained', [App\Http\Controllers\HomeController::class, 'sustained'])->name('sustained');
    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settingsForm'])->name('settings');
    Route::post('/update_settings', [App\Http\Controllers\HomeController::class, 'update_settings'])->name('update_settings');
    Route::get('/manageusers', [App\Http\Controllers\UserController::class, 'index'])->name('Manage_users');
    Route::post('/delete_user', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete_user');
    Route::post('/enable_user', [App\Http\Controllers\UserController::class, 'enableUser'])->name('enable_user');
    Route::post('/to_notify_user', [App\Http\Controllers\UserController::class, 'toNotifyUser'])->name('to_notify_user');
    Route::post('/disable_user', [App\Http\Controllers\UserController::class, 'disableUser'])->name('disable_user');
    Route::post('/filter_role', [App\Http\Controllers\ManageController::class, 'filter_role'])->name('filter_role');
    Route::get('/managepatients', [App\Http\Controllers\PatientController::class, 'index'])->name('Manage_patients');

    // need to verify if included token is valid
    Route::get('confirm/{sessionid}', [App\Http\Controllers\AppointmentController::class, 'ConfirmAppointment'])->name('ConfirmAppointment');
    Route::post('confirm_appointment', [App\Http\Controllers\AppointmentController::class, 'confirm_appointment'])->name('confirm_appointment');

    Route::post('/cancel_appointment', [App\Http\Controllers\SessionController::class, 'CancelSession']);

    //summary how many patient
    Route::get('report/patientSummary', [App\Http\Controllers\ReportController::class, 'patientSummary'])->name('patientSummary');

    // to generate patient code manually
    Route::get('/GeneratePatientCode', [App\Http\Controllers\PatientController::class, 'generate_patient_code']);
    Route::post('/GetPatientCount', [App\Http\Controllers\PatientController::class, 'get_patient_count']);
});

// skip authentication
Route::get('/registerhcp', [App\Http\Controllers\HomeController::class, 'registerhcp'])->name('registerhcp');

Route::resource('roles', RoleController::class);
Route::resource('clinics', ClinicController::class);

//twilio
// Route::get('sendsms', [App\Http\Controllers\TwilioSMSController::class, 'sendsms']);

// mail
// Route::get('sendemail', [App\Http\Controllers\MailerController::class, 'sendemail']);

//test twilio
Route::get('testsms', [App\Http\Controllers\TwilioSMSController::class, 'testsms']);
