<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Announcement;
use App\Models\Service;
use App\Models\FileAttachment;
use App\Models\Setting;
use App\Mail\RegistrationCompleteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Auth;
use Storage;

class WebsiteController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function services()
    {
        $data = [
            'services' => Service::orderBy('created_at', 'DESC')->get()
        ]; 
        return view('services', $data);
    }

    public function announcements()
    {
        $data = [
            'announcements' => Announcement::orderBy('created_at', 'DESC')->get()
        ]; 
        return view('announcements', $data);
    }

    public function viewAnnouncement(Announcement $announcement)
    {
        $data = [
            'announcement' => $announcement
        ]; 
        return view('view_announcement', $data);
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function ourStory()
    {
        return view('our_story');
    }

    public function ourOrganization()
    {
        return view('our_organization');
    }

    public function trackAppointment(Request $request)
    {
        $data = [];
        if($request->get('reference_code') != null){
            $appointment = Appointment::where('created_at', Carbon::createFromTimestamp($request->get('reference_code'))->toDateTimeString())->first();
            $data = [
                'appointment' => $appointment
            ];
        }
        return view('track_appointment', $data);
    }

    public function contactUs()
    {
        return view('contact_us');
    }

    public function patientRegistration(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255'],
            'occupation' => ['string', 'max:255'],
            'contact_number' => ['string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $username = time();
        $email = is_null($request->get('email')) ? $username.'@temp.com' : $request->get('email');
        // $password = $username . Carbon::parse($request->get('birthdate'))->format('Y');
        $patient = User::create([
            'role_id' => 4,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'sex' => $request->get('sex'),
            'birthdate' => $request->get('birthdate'),
            'address' => $request->get('address'),
            'occupation' => $request->get('occupation'),
            'contact_number' => $request->get('contact_number'),
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($request->get('password')),
        ]);
        $patient->assignRole(4);
        Auth::attempt(['username' => $patient->username, 'password' => $request->get('password')]);
        // Send SMS
        if(Setting::system('send_sms_notification')){
            $this->sendPatientCredentialsSMS($patient);
        }

        // Send Mail
        if(Setting::system('send_email_notification')){
            if($request->get('email')){
                Mail::to($patient->email)->send(new RegistrationCompleteMail($patient));
            }
        }

        $data = [
            'patient' => $patient
        ];
        
        return redirect()->route('registration_complete', $patient->username);
    }

    public function patientRegistrationComplete($username)
    {
        $patient = User::where('username', $username)->first();
        // Auth::attempt(['username' => $patient->username, 'password' => $patient->password]);
        $data = [
            'patient' => $patient
        ];
        return view('registration_complete', $data);
    }

    public function sendPatientCredentialsSMS($patient)
    {
        $account_sid = config("app.twilio_sid");
        $auth_token = config("app.twilio_auth_token");
        $twilio_number = config("app.twilio_number");
        $client = new Client($account_sid, $auth_token);
        $message = "\n\nHi ". $patient->first_name ." ". $patient->last_name .". You successfully registered on ". config('app.url') .". Your can now use your Username or Email to login to our system. \n\nUsername: ". $patient->username ."\nTo protect you account, please do not share your login credentials.";
        $client->messages->create('+639673700022', [
            'from' => $twilio_number,
            'body' => $message
        ]);
    }

    public function myProfile($username)
    {
        if(User::where('username', $username)->exists()){
			$user = User::where('username', $username)->first();
			if(Auth::user()->id == $user->id){
				$data = [
					'user' => $user,
				];
				return view('my_profile', $data);
			}else{
				return abort(401);
			}
		}else{
			return abort(404);
		}
    }

    public function updateMyProfile(Request $request, $username)
	{
		if(User::where('username', $username)->exists()){
			$user = User::where('username', $username)->first();
			if(Auth::user()->id == $user->id){
				$request->validate([
					'avatar' => 'nullable|dimensions:ratio=1/1|image|mimes:jpeg,png,jpg',
					'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
                    'address' => ['string', 'max:255'],
                    'occupation' => ['string', 'max:255'],
                    'contact_number' => ['string', 'max:255'],
				]);
                $email = is_null($request->get('email')) ? $user->username.'@temp.com' : $request->get('email');
                $user->update([
                    'address' => $request->get('address'),
                    'occupation' => $request->get('occupation'),
                    'contact_number' => $request->get('contact_number'),
                    'email' => $email,
                ]);
				if($request->filled('password')){
					$request->validate([
						'password' => [/*'required',*/ 'string', 'min:6', 'confirmed']
					]);
					$user->update([
						'password' => Hash::make($request->get('password')),
					]);
				}
				
				$attachment_id = null;
				if($request->file('avatar') != null){
					$file = $request->file('avatar');
					$data = file_get_contents($file);
					$base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
					$file_name = time().'.'.$file->extension();
					$path = 'File Attachments/User/Image';
					$old_image = isset($user->avatar->data) ? $user->avatar->data : null;
					if($base64 != $old_image){
						$attachment = FileAttachment::create([
							'file_path' => $path,
							'file_type' => $file->extension(),
							'file_extension' => $file->extension(),
							'file_name' => $file_name,
							'data' => $base64,
						]);
						Storage::disk('upload')->putFileAs($path, $file, $file_name);
						$user->update([
							'avatar_file_attachment_id' => $attachment->id
						]);
					}
				}
				return redirect()->route('my-profile', Auth::user()->username)->with('alert-success', 'Profile saved');
			}else{
				return abort(401);
			}
		}else{
			return abort(404);
		}
	}
}
