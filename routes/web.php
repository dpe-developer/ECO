<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Auth::routes();

/**
 * Routes require Auth and Permission
 */
// Route::get('home', 'WebsiteController@home');
Route::get('home', 'WebsiteController@home')->name('home');
Route::get('services', 'WebsiteController@services');
Route::get('announcements', 'WebsiteController@announcements');
Route::get('gallery', 'WebsiteController@gallery');
Route::get('our-story', 'WebsiteController@ourStory');
Route::get('our-organization', 'WebsiteController@ourOrganization');
Route::get('track-appointment', 'WebsiteController@trackAppointment');
Route::get('contact-us', 'WebsiteController@contactUs');
Route::post('patient-registration', 'WebsiteController@patientRegistration');
Route::get('registration-complete', 'WebsiteController@patientRegistrationComplete');

Route::group(['middleware' => ['role:System Administrator']], function () {
	/**
	 * Login Info/Client Info
	 */
	Route::resource('login_infos', 'LoginInfoController');
	Route::get('settings/migrate-users-ui-settings', [
		'as' => 'settings.migrate_ui_user_settings',
		'uses' => 'SettingsController@migrateUsersUISettings'
	]);

});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::group(array('middleware'=>['auth']), function() {

	/**
	 * Appointments
	 */
	Route::resource('appointments', 'AppointmentController');
	Route::get('appointment-confirm/{appointment}', [
		'as' => 'appointments.confirm',
		'uses' => 'AppointmentController@confirmAppointment'
	]);
	Route::get('appointment-cancel/{appointment}', [
		'as' => 'appointments.cancel',
		'uses' => 'AppointmentController@cancelAppointment'
	]);
	Route::post('appointment-decline/{appointment}', [
		'as' => 'appointments.decline',
		'uses' => 'AppointmentController@declineAppointment'
	]);
	Route::get('appointment-accept/{appointment}', [
		'as' => 'appointments.accept_patient',
		'uses' => 'AppointmentController@acceptPatient'
	]);
	// restore
	Route::post('appointments_restore/{appointment}', [
		'as' => 'appointments.restore',
		'uses' => 'AppointmentController@restore'
	]);

	/**
	 * Patient Visit
	 */
	Route::resource('patient_visits', 'PatientVisitController');
	// restore
	Route::post('patient_visits_restore/{patient_visit}', [
		'as' => 'patient_visits.restore',
		'uses' => 'PatientVisitController@restore'
	]);

	/**
	 * Patient
	 */
	Route::resource('patients', 'PatientController');
	/**
	 * Patient Appointments
	 */
	Route::resource('patient_appointments', 'PatientAppointmentController')->parameters([
		'patient_appointments' => 'appointment'
	]);

    /**
     * Users
     */
    Route::resource('users', 'UserController');
	Route::get('profile/{username}', [
		'as' => 'users.profile',
		'uses' => 'UserController@profile'
	]);
	Route::get('profile/edit/{username}', [
		'as' => 'users.edit_profile',
		'uses' => 'UserController@editProfile'
	]);
	Route::put('profile/update/{username}', [
		'as' => 'users.update_profile',
		'uses' => 'UserController@updateProfile'
	]);
	Route::put('user/update-user-interface', [
		'as' => 'users.edit_user_interface',
		'uses' => 'UserController@editUserInterface'
	]);
	Route::get('user/reset-user-interface', [
		'as' => 'users.reset_user_interface',
		'uses' => 'UserController@resetUserInterface'
	]);
    // restore
	Route::post('users_restore/{user}', [
		'as' => 'users.restore',
		'uses' => 'UserController@restore'
	]);
    /**
	 * ----------------------------------------------
	 * 					Configuration
	 * ----------------------------------------------
	 */
	Route::resource('roles', 'RolePermission\RoleController');
	// Route::get('/roles_get_data', 'RolePermission\RoleController@get_data')->name('roles.get_data');
	// restore
	Route::post('roles/restore/{role}', [
		'as' => 'roles.restore',
		'uses' => 'RolePermission\RoleController@restore'
	]);

	Route::resource('permissions', 'RolePermission\PermissionController');
	// Route::get('/permissions_get_data', 'RolePermission\PermissionController@get_data')->name('permissions.get_data');
	// restore
	Route::post('permissions/restore/{permission}', [
		'as' => 'permissions.restore',
		'uses' => 'RolePermission\PermissionController@restore'
	]);

	// settings
	// Route::resource('settings', 'SettingsController')->only('index', 'update');
	Route::get('settings', [
		'as' => 'settings.index',
		'uses' => 'SettingsController@index'
	]);
	Route::put('settings/update-company', [
		'as' => 'settings.edit_company',
		'uses' => 'SettingsController@updateCompany'
	]);
	Route::get('settings/reset-company', [
		'as' => 'settings.reset_company',
		'uses' => 'SettingsController@resetCompany'
	]);
	Route::put('settings/update-user-interface', [
		'as' => 'settings.edit_user_interface',
		'uses' => 'SettingsController@updateUserInterface'
	]);
	Route::get('settings/reset-user-interface', [
		'as' => 'settings.reset_user_interface',
		'uses' => 'SettingsController@resetUserInterface'
	]);
	Route::put('settings/update-system', [
		'as' => 'settings.edit_system',
		'uses' => 'SettingsController@updateSystem'
	]);
	Route::get('settings/reset-system', [
		'as' => 'settings.reset_system',
		'uses' => 'SettingsController@resetSystem'
	]);
	/**
	 * ----------------------------------------------
	 * 			    End of Configuration
	 * ----------------------------------------------
	 */
});
