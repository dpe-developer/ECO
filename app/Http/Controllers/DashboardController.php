<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Finding;
use App\Models\PatientVisit;
use App\Models\RolePermission\Role;
use App\Models\RolePermission\Permission;
use App\Models\LoginInfo;
use App\Charts\AppointmentsThisWeek;
use App\Charts\FindingsThisMonth;
use Carbon;
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
            'patients' => User::where('role_id', 4)->count(),
            'pendingAppointments' => Appointment::where('status', 'pending')->count(),
            'confirmedAppointments' => Appointment::where('status', 'confirmed')->count(),
            'appointmentsToday' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'appointmentsThisWeekChart' => $this->appointmentsThisWeek(),
            'findingsThisMonthChart' => $this->findingsThisMonth(),
        ];
        return view('dashboard', $data);
    }
    
    public function findingsThisMonth()
    {
        $findingsThisMonthChart = new FindingsThisMonth;
        $labels = [];
        $labelColors = [];
        $findingsThisMonthChartData = [];
        $totalFindingsThisMonth = 0;

        foreach(Finding::get() as $finding){
            $patientVisitsThisMonthFromFindings = PatientVisit::whereMonth('visit_date', Carbon::now()->month)->whereYear('visit_date', Carbon::now()->year)
            ->where('findings', 'LIKE', '%'.$finding->name.'%')->where('findings', '!=', null)->count();
            $totalFindingsThisMonth = $totalFindingsThisMonth + $patientVisitsThisMonthFromFindings;
        }
        foreach(Finding::get() as $finding){
            $percentage = 0;
            $patientVisitsThisMonthFromFindings = PatientVisit::whereMonth('visit_date', Carbon::now()->month)->whereYear('visit_date', Carbon::now()->year)
            ->where('findings', 'LIKE', '%'.$finding->name.'%')->where('findings', '!=', null)->count();
            if($patientVisitsThisMonthFromFindings){
                $percentage = number_format(($patientVisitsThisMonthFromFindings / $totalFindingsThisMonth) * 100, 0);
                if($percentage > 2){
                    $labels[] = $finding->name . " " . $percentage . "%";
                    $red = mt_rand(0, 255);
                    $green = mt_rand(0, 255);
                    $blue = mt_rand(0, 255);
                    $redColor = $percentage*10;
                    $greenColor = 255-($percentage*6);
                    $blueColor = 0;
                    $hexColor = sprintf("#%02x%02x%02x", ($redColor >= 255 ? 255 : $redColor), ($greenColor <= 0 ? 0 : $greenColor), ($blueColor >= 255 ? 0 : $blueColor));
                    $labelColors[] = $hexColor;
                    $findingsThisMonthChartData[] = $patientVisitsThisMonthFromFindings;
                }
            }
        }


        $findingsThisMonthChart->labels($labels);
        $findingsThisMonthChart->dataset('Findings this Month', 'pie', $findingsThisMonthChartData)->backgroundColor($labelColors)->color('#FFF');

        $findingsThisMonthChart->options([
            'scales' => [
                'yAxes' => [[
                    'display' => false,
                ]],
                'xAxes' => [[
                    'display' => false,
                ]]
            ],
        ]);
        return $findingsThisMonthChart;
    }

    public function appointmentsThisWeek()
    {
        $appointmentsThisWeekChart = new AppointmentsThisWeek;
        $startOfWeek = Carbon::now()->startOfWeek(); // get the start date of the week
        $endOfWeek = Carbon::now()->endOfWeek(); // get the end date of the week
        // $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $daysOfWeek = [];
        $appointmentStatus = ['pending', 'confirmed', 'canceled', 'declined', 'done'];
        
        $appointmentsThisWeekChartData = [];
        // Generate all dates of the week
        $datesOfWeek = [];
        while ($startOfWeek->lte($endOfWeek)) {
            $datesOfWeek[] = $startOfWeek->copy(); // copy the date to avoid modifying the original instance
            $daysOfWeek[] = $startOfWeek->format('l');
            $startOfWeek->addDay(); // move to the next day
        }
        foreach ($appointmentStatus as $status) {
            $appointmentsThisWeekChartData[$status] = [];
        }

        $appointmentsThisWeekChart->labels($daysOfWeek);

        foreach($datesOfWeek as $date){
            foreach($appointmentStatus as $status){
                $appointmentsThisWeekChartData[$status][] = Appointment::whereDate('appointment_date', $date)->where('status', $status)->count();
            }
        }
        $appointmentsThisWeekChart->dataset("Pending", "bar", $appointmentsThisWeekChartData['pending'])->backgroundColor('#ffc107');
        $appointmentsThisWeekChart->dataset("Confirmed", "bar", $appointmentsThisWeekChartData['confirmed'])->backgroundColor('#007bff');
        $appointmentsThisWeekChart->dataset("Canceled", "bar", $appointmentsThisWeekChartData['canceled'])->backgroundColor('#fd7e14');
        $appointmentsThisWeekChart->dataset("Declined", "bar", $appointmentsThisWeekChartData['declined'])->backgroundColor('#dc3545');
        $appointmentsThisWeekChart->dataset("Done", "bar", $appointmentsThisWeekChartData['done'])->backgroundColor('#28a745');
        $appointmentsThisWeekChart->options([
            // 'min-height' => '250px',
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                        'stepSize' => 5,
                    ],
                    'gridLines' => [
                        'display' => false
                    ]
                ]],
                'xAxes' => [[
                    'gridLines' => [
                        'display' => true
                    ]
                ]]
            ]
        ]);
        return $appointmentsThisWeekChart;
    }
}
