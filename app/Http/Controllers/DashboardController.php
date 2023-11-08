<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use App\Models\User;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\Permission;
use App\Models\LoginInfo;
use Twilio\Rest\Client;
use InfobipAPI;
use SendSMSApi;
use SmsDestination;
use SmsTextualMessage;
use SmsAdvancedTextualRequest;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:System Administrator|Administrator|Doctor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* $account_sid = config("app.twilio_sid");
        $auth_token = config("app.twilio_auth_token");
        $twilio_number = config("app.twilio_number");
        $client = new Client($account_sid, $auth_token);
        $message = "\n\nHi, this is a sample. This is your login credentials on https://dizonvisionclinic.dpe \n\nUsername: 1234567890";
        $client->messages->create(
            '+639673700022', 
                [
                'from' => $twilio_number,
                'body' => $message
            ]
        ); */

        /* $configuration = (new InfobipConfiguration())
            ->setHost(config('app.infobip_api_base_url'))
            ->setApiKeyPrefix('Authorization', config('app.infobip_api_prefix'))
            ->setApiKey('Authorization', config('app.infobip_api_key'));

        $client = new GuzzleHttpClient();

        $sendSmsApi = new SendSMSApi($client, $configuration);
        $destination = (new SmsDestination())->setTo('4412345678910');
        $message = (new SmsTextualMessage())
            ->setFrom('InfoSMS')
            ->setText('This is a dummy SMS message sent using infobip-api-php-client')
            ->setDestinations([$destination]);
        $request = (new SmsAdvancedTextualRequest())
            ->setMessages([$message]); */


        // return view('home');
        $data = [
            'users' => User::where('id', '!=', 1)->get(),
            'loginInfos' => LoginInfo::get(),
            'permissions' => Permission::get(),
            'roles' => Role::get(),
        ];
        return view('dashboard', $data);
    }
}
