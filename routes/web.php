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
Route::get('clinic-announcements', 'WebsiteController@announcements');
Route::get('news-feed', 'WebsiteController@newsFeed');
Route::get('news-feed/view/{newsFeed}', 'WebsiteController@viewNewsFeed');
Route::get('clinic-announcements/view/{announcement}', 'WebsiteController@viewAnnouncement');
Route::get('gallery', 'WebsiteController@gallery');
Route::get('our-story', 'WebsiteController@ourStory');
Route::get('our-organization', 'WebsiteController@ourOrganization');
Route::get('track-appointment', 'WebsiteController@trackAppointment')->name('track-appointment');
Route::get('contact-us', 'WebsiteController@contactUs');
Route::post('submit-inquiry', 'WebsiteController@submitInquiry')->name('submit_inquiry');
Route::post('patient-registration', 'WebsiteController@patientRegistration');
Route::get('registration-complete/{username}', 'WebsiteController@patientRegistrationComplete')->name('registration_complete');

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

Route::group(['middleware' => ['auth', 'role:Patient']], function () {
	Route::get('my-profile/{username}', [
		'as' => 'my-profile',
		'uses' => 'WebsiteController@myProfile'
	]);
	Route::put('update-my-profile/{username}', [
		'as' => 'update-my-profile',
		'uses' => 'WebsiteController@updateMyProfile'
	]);
	Route::post('patient-appointment-cancel/{appointment}', [
		'as' => 'patient_appointments.cancel',
		'uses' => 'PatientAppointmentController@cancelAppointment'
	]);
	/**
	 * Patient Appointments
	 */
	Route::resource('patient_appointments', 'PatientAppointmentController')->parameters([
		'patient_appointments' => 'appointment'
	]);
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
/**
 * Filter Dashboard Chart
 */
Route::get('/dashboard/filter-findings-chart', 'DashboardController@filterFindingsChartAjax')->name('dashboard.filter_findings_chart');
Route::get('/dashboard/filter-findings-by-patient-age-chart', 'DashboardController@filterFindingsByPatientAgeAjax')->name('dashboard.filter_findings_by_patient_age_chart');
Route::get('/dashboard/filter-appointments-chart', 'DashboardController@filterAppointmentsAjax')->name('dashboard.filter_appointments_chart');

Route::group(array('middleware'=>['auth', 'role:System Administrator|Administrator|Doctor']), function() {


	/**
	 * File Attachments
	 */
	Route::resource('file_attachments', 'FileAttachmentController');
	Route::post('file_attachment/upload-files', [
		'as' => 'file_attachments.upload_files',
		'uses' => 'FileAttachmentController@uploadFiles'
	]);

	/**
	 * Findings
	 */
	Route::resource('findings', 'FindingController');

	/**
	 * Announcements
	 */
	Route::resource('announcements', 'AnnouncementController');

	/**
	 * Newsfeed
	 */
	Route::resource('news_feeds', 'NewsFeedController')->parameters([
		'news_feeds' => 'newsFeed'
	]);

	/**
	 * Appointments
	 */
	Route::resource('appointments', 'AppointmentController');
	Route::get('appointment-confirm/{appointment}', [
		'as' => 'appointments.confirm',
		'uses' => 'AppointmentController@confirmAppointment'
	]);
	Route::post('appointment-cancel/{appointment}', [
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
	Route::get('appointment/get-time-taken', [
		'as' => 'appointments.get_time_taken',
		'uses' => 'AppointmentController@getTimeTaken'
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
	Route::get('patient_visits/end-visit/{patientVisit}', [
		'as' => 'patient_visits.end_visit',
		'uses' => 'PatientVisitController@endVisit'
	]);
	// restore
	Route::post('patient_visits_restore/{patient_visit}', [
		'as' => 'patient_visits.restore',
		'uses' => 'PatientVisitController@restore'
	]);
	

	/**
	 * Patient
	 */
	Route::resource('patients', 'PatientController')->parameters([
		'patients' => 'user'
	]);
	Route::post('patients-import-data', [
		'as' => 'patients.import_data',
		'uses' => 'PatientController@importData'
	]);
	Route::get('patients-export-data', [
		'as' => 'patients.export_data',
		'uses' => 'PatientController@exportData'
	]);
	// restore
	Route::post('patients-restore/{user}', [
		'as' => 'patients.restore',
		'uses' => 'PatientController@restore'
	]);

	/**
	 * Patient Medical Histories
	 */
	Route::resource('medical_histories', 'PatientProfile\MedicalHistory\MedicalHistoryController')->parameters([
		'medical_histories' => 'medical_history'
	]);
	Route::resource('medical_history_references', 'PatientProfile\MedicalHistory\MedicalHistoryReferenceController');

	/**
	 * Patient Eye Prescriptions
	 */
	Route::resource('eye_prescriptions', 'PatientProfile\EyePrescription\EyePrescriptionController');
	Route::resource('eye_prescription_references', 'PatientProfile\EyePrescription\EyePrescriptionReferenceController');

	/**
	 * Patient Complaints
	 */
	Route::resource('complaints', 'PatientProfile\Complaint\ComplaintController');
	Route::resource('complaint_references', 'PatientProfile\Complaint\ComplaintReferenceController');

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
