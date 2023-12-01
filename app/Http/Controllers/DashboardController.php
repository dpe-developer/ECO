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
use App\Charts\FindingsByPatientAgeChart;
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
        $this->patients = User::where('role_id', 4);
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
            'findingsByPatientAgeChart' => $this->findingsByPatientAge(),
            'appointmentsThisWeekChart' => $this->appointmentsThisWeek(),
            'findingsThisMonthChart' => $this->findingsThisMonth(),
        ];
        return view('dashboard', $data);
    }

    public function findingsByPatientAge()
    {
        $findingsByPatientAge = new FindingsByPatientAgeChart;

        /* foreach(PatientVisit::whereNotNull('findings')->get() as $patientVisit){
            
        } */
        $findingsByPatientAgeLabels = [];
        $findingsByAge = [
            '1-10' => [0,0,0,0,0,0,0,0],
            '11-20' => [0,0,0,0,0,0,0,0],
            '21-30' => [0,0,0,0,0,0,0,0],
            '31-40' => [0,0,0,0,0,0,0,0],
            '41-50' => [0,0,0,0,0,0,0,0],
            '51-60' => [0,0,0,0,0,0,0,0],
            '60 above' => [0,0,0,0,0,0,0,0]
        ];
        foreach(Finding::get() as $finding){
            $findingsByPatientAgeLabels[] = $finding->name;
        }
        $findingsByPatientAge->labels($findingsByPatientAgeLabels);

        foreach(Finding::get() as $index => $finding){
            $patientVisitsByFindings = PatientVisit::where('patient_visits.findings', '!=', null)
            ->where('patient_visits.findings', 'LIKE', '%'.explode('/', $finding->name)[0].'%')->get();
            foreach($patientVisitsByFindings as $patientVisitByFinding){
                $patientAge = $patientVisitByFinding->patient->age($patientVisitByFinding->visit_date);
                if($patientAge < 11){
                    $findingsByAge['1-10'][$index] += 1; 
                }
                if($patientAge > 10 && $patientAge < 21){
                    $findingsByAge['11-20'][$index] += 1; 
                }
                if($patientAge > 20 && $patientAge < 31){
                    $findingsByAge['21-30'][$index] += 1; 
                }
                if($patientAge > 30 && $patientAge < 41){
                    $findingsByAge['31-40'][$index] += 1; 
                }
                if($patientAge > 40 && $patientAge < 51){
                    $findingsByAge['41-50'][$index] += 1; 
                }
                if($patientAge > 50 && $patientAge < 61){
                    $findingsByAge['51-60'][$index] += 1; 
                }
                if($patientAge > 60){
                    $findingsByAge['60 above'][$index] += 1; 
                }
            }
        }
        $findingsByPatientAge->dataset("Age 1-10", "bar", $findingsByAge['1-10'])->backgroundColor('#009900');
        $findingsByPatientAge->dataset("Age 11-20", "bar", $findingsByAge['11-20'])->backgroundColor('#33FF33');
        $findingsByPatientAge->dataset("Age 21-30", "bar", $findingsByAge['21-30'])->backgroundColor('#CCCC33');
        $findingsByPatientAge->dataset("Age 31-40", "bar", $findingsByAge['31-40'])->backgroundColor('yellow');
        $findingsByPatientAge->dataset("Age 41-50", "bar", $findingsByAge['41-50'])->backgroundColor('#FF6600');
        $findingsByPatientAge->dataset("Age 51-60", "bar", $findingsByAge['51-60'])->backgroundColor('#FF0000');
        $findingsByPatientAge->dataset("Age 60 above", "bar", $findingsByAge['60 above'])->backgroundColor('#990000');
        $findingsByPatientAge->options([
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
        return $findingsByPatientAge;
    }
    
    public function findingsThisMonth()
    {
        $findingsThisMonthChart = new FindingsThisMonth;
        $labels = [];
        $labelColors = [];
        $findingsThisMonthChartData = [];
        $totalFindingsThisMonth = 0;
        $dateToFilter = 'visit_date';
        $colors =  [
            '#009900',
            'pink',
            'purple',
            'yellow',
            '#FF6600',
            '#FF0000',
            'silver',
            'blue',
        ];

        foreach(Finding::get() as $finding){
            $patientVisitsThisMonthFromFindings = PatientVisit::whereMonth($dateToFilter, Carbon::now()->month)->whereYear($dateToFilter, Carbon::now()->year)
            ->where('findings', 'LIKE', '%'.explode('/', $finding->name)[0].'%')->where('findings', '!=', null)->count();
            $totalFindingsThisMonth = $totalFindingsThisMonth + $patientVisitsThisMonthFromFindings;
        }
        foreach(Finding::get() as $i => $finding){
            $percentage = 0;
            $patientVisitsThisMonthFromFindings = PatientVisit::whereMonth($dateToFilter, Carbon::now()->month)->whereYear($dateToFilter, Carbon::now()->year)
            ->where('findings', 'LIKE', '%'.explode('/', $finding->name)[0].'%')->where('findings', '!=', null)->count();
            if($patientVisitsThisMonthFromFindings){
                $percentage = number_format(($patientVisitsThisMonthFromFindings / $totalFindingsThisMonth) * 100, 0);
                // if($percentage > 2){
                    $labels[] = $finding->name . " " . $percentage . "%";
                    $red = mt_rand(0, 255);
                    $green = mt_rand(0, 255);
                    $blue = mt_rand(0, 255);
                    $redColor = 200;
                    $greenColor = 255-($percentage*5);
                    $blueColor = 0;
                    $hexColor = sprintf("#%02x%02x%02x", ($redColor >= 255 ? 255 : $redColor), ($greenColor <= 0 ? 0 : $greenColor), ($blueColor >= 255 ? 0 : $blueColor));
                    $labelColors[] = $colors[$i];
                    $findingsThisMonthChartData[] = $patientVisitsThisMonthFromFindings;
                // }
            }
        }


        $findingsThisMonthChart->labels($labels);
        $findingsThisMonthChart->dataset('Findings this Month', 'pie', $findingsThisMonthChartData)->backgroundColor($labelColors)->color('black');

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
