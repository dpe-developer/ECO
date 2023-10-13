<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Mail\SampleMail;
use App\Mail\RegistrationCompleteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Auth;

class WebsiteController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function services()
    {
        return view('services');
    }

    public function announcements()
    {
        return view('announcements');
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
            'email' => ['string', 'email', 'max:255', 'unique:users'],
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

        // Send SMS
        // $this->sendPatientCredentialsSMS($patient);

        // Send Mail
        if($request->get('email')){
            Mail::to($patient->email)->send(new RegistrationCompleteMail($patient));
        }

        $data = [
            'patient' => $patient
        ];
        return view('registration_complete', $data);
    }

    public function patientRegistrationComplete()
    {
        // Mail::to("dpe.developer001@gmail.com")->send(new SampleMail());
        return view('registration_complete');
    }

    public function sendPatientCredentialsSMS($patient)
    {
        $account_sid = config("app.twilio_sid");
        $auth_token = config("app.twilio_auth_token");
        $twilio_number = config("app.twilio_number");
        $client = new Client($account_sid, $auth_token);
        $message = "\n\nHi ". $patient->first_name ." ". $patient->last_name .". This is your login credentials on https://dizonvisionclinic.dpe \n\nUsername: 1234567890";
        $client->messages->create('+639673700022', [
            'from' => $twilio_number,
            'body' => $message
        ]);
    }
}
