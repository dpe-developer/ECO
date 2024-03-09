<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class DashboardController extends Controller
{
    protected $patients;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:System Administrator|Administrator|Doctor');
        $this->patients = User::where('role_id', 4);
    }

    public function index(Request $request)
    {
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

    public function appointmentsThisWeek()
    {
        $appointmentsThisWeekChart = new AppointmentsThisWeek;
        $startOfWeek = Carbon::now()->startOfWeek(); // get the start date of the week
        $endOfWeek = Carbon::now()->endOfWeek(); // get the end date of the week
        $daysOfWeek = [];
        $appointmentStatus = ['pending', 'confirmed', 'canceled', 'declined', 'done'];
        
        $appointmentsThisWeekChartData = [];
        $datesOfWeek = [];
        while ($startOfWeek->lte($endOfWeek)) {
            $datesOfWeek[] = $startOfWeek->copy();
            $daysOfWeek[] = $startOfWeek->format('l, F d');
            $startOfWeek->addDay();
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
            'scales' => [
                'yAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Number of Appointments"
                    ],
                    'ticks' => [
                        'stepSize' => 1,
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

    public function findingsThisMonth()
    {
        $findingsThisMonthChart = new FindingsThisMonth;
        $labels = [];
        $labelColors = [];
        $findingsThisMonthChartData = [];
        $totalFindingsThisMonth = 0;
        $dateToFilter = 'visit_date';

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
                $labels[] = $finding->name . " " . $percentage . "%";
                $labelColors[] = $this->generateRandomColor($percentage);
                $findingsThisMonthChartData[] = $patientVisitsThisMonthFromFindings;
            }
        }


        $findingsThisMonthChart->labels($labels);
        $findingsThisMonthChart->dataset('Findings this Month', 'pie', $findingsThisMonthChartData)->backgroundColor($labelColors)->color('black');
        $findingsThisMonthChart->options([
            'legend' => [
                'display' => true,
            ],
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

    public function findingsByPatientAge()
    {
        $findingsByPatientAge = new FindingsByPatientAgeChart;

        $findingsByPatientAgeLabels = [];
        $findingsCount = [];
        
        foreach(Finding::get() as $i =>$finding){
            $findingsByPatientAgeLabels[] = $finding->name;
            $findingsCount[] = 0;
        }
        $findingsByPatientAge->labels($findingsByPatientAgeLabels);
        $findingsByAge = [
            '1-10' => $findingsCount,
            '11-20' => $findingsCount,
            '21-30' => $findingsCount,
            '31-40' => $findingsCount,
            '41-50' => $findingsCount,
            '51-60' => $findingsCount,
            '60 above' =>$findingsCount
        ];
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
        $findingsByPatientAge->dataset("Age 1-10", "bar", $findingsByAge['1-10'])->backgroundColor('violet');
        $findingsByPatientAge->dataset("Age 11-20", "bar", $findingsByAge['11-20'])->backgroundColor('#33FF33');
        $findingsByPatientAge->dataset("Age 21-30", "bar", $findingsByAge['21-30'])->backgroundColor('blue');
        $findingsByPatientAge->dataset("Age 31-40", "bar", $findingsByAge['31-40'])->backgroundColor('yellow');
        $findingsByPatientAge->dataset("Age 41-50", "bar", $findingsByAge['41-50'])->backgroundColor('#FF6600');
        $findingsByPatientAge->dataset("Age 51-60", "bar", $findingsByAge['51-60'])->backgroundColor('#FF0000');
        $findingsByPatientAge->dataset("Age 60 above", "bar", $findingsByAge['60 above'])->backgroundColor('#990000');
        $findingsByPatientAge->options([
            'scales' => [
                'yAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Number of Patients"
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                    'gridLines' => [
                        'display' => true
                    ]
                ]],
                'xAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Findings"
                    ],
                    'gridLines' => [
                        'display' => true
                    ]
                ]]
            ]
        ]);
        return $findingsByPatientAge;
    }


    public function filterAppointmentAjax(Request $request)
    {
        $appointmentsThisWeekChart = new AppointmentsThisWeek;
        $startOfWeek = Carbon::now()->startOfWeek(); // get the start date of the week
        $endOfWeek = Carbon::now()->endOfWeek(); // get the end date of the week
        $daysOfWeek = [];
        $appointmentStatus = ['pending', 'confirmed', 'canceled', 'declined', 'done'];
        
        $appointmentsThisWeekChartData = [];
        $datesOfWeek = [];
        while ($startOfWeek->lte($endOfWeek)) {
            $datesOfWeek[] = $startOfWeek->copy(); // copy the date to avoid modifying the original instance
            $datesFromFilter[] = $startOfWeek->format('l, F d');
            $startOfWeek->addDay(); // move to the next day
        }
        
        foreach ($appointmentStatus as $status) {
            $appointmentsThisWeekChartData[$status] = [];
        }

        foreach($datesOfWeek as $date){
            foreach($appointmentStatus as $status){
                $appointmentsThisWeekChartData[$status][] = Appointment::whereDate('appointment_date', $date)->where('status', $status)->count();
            }
        }
        $appointmentsThisWeekChart->labels($datesFromFilter);
        $appointmentsThisWeekChart->dataset("Pending", "bar", $appointmentsThisWeekChartData['pending'])->backgroundColor('#ffc107');
        $appointmentsThisWeekChart->dataset("Confirmed", "bar", $appointmentsThisWeekChartData['confirmed'])->backgroundColor('#007bff');
        $appointmentsThisWeekChart->dataset("Canceled", "bar", $appointmentsThisWeekChartData['canceled'])->backgroundColor('#fd7e14');
        $appointmentsThisWeekChart->dataset("Declined", "bar", $appointmentsThisWeekChartData['declined'])->backgroundColor('#dc3545');
        $appointmentsThisWeekChart->dataset("Done", "bar", $appointmentsThisWeekChartData['done'])->backgroundColor('#28a745');
        $appointmentsThisWeekChart->options([
            'scales' => [
                'yAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Number of Appointments"
                    ],
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

        return response()->json([
            'chart' => $appointmentsThisWeekChart,
            'dateOption' => $request->get('filter_date_option'),
            // 'dateFilter' => Carbon::parse($dateFilter)->format('F d,Y'),
            // 'dateFrom' => Carbon::parse($dateFrom)->format('F d,Y'),
            // 'dateTo' => Carbon::parse($dateTo)->format('F d,Y'),
        ]);
    }

    public function filterFindingsByPatientAgeAjax(Request $request)
    {
        $dateFrom = null;
        $dateTo = null;
        $dateFilter = null;
        $filterDateColumn = 'visit_date';
        $findingsByPatientAge = new FindingsByPatientAgeChart;
        $findingsByPatientAgeLabels = [];
        $findingsCount = [];

        
        foreach(Finding::get() as $i =>$finding){
            $findingsByPatientAgeLabels[] = $finding->name;
            $findingsCount[] = 0;
        }
        $findingsByPatientAge->labels($findingsByPatientAgeLabels);
        $findingsByAge = [
            '1-10' => $findingsCount,
            '11-20' => $findingsCount,
            '21-30' => $findingsCount,
            '31-40' => $findingsCount,
            '41-50' => $findingsCount,
            '51-60' => $findingsCount,
            '60 above' =>$findingsCount
        ];
        foreach(Finding::get() as $index => $finding){
            $patientVisits = PatientVisit::select('*');
            if($request->get('filter_date_option')){
                switch ($request->get('filter_date_option')) {
                    case 'today':
                        $dateFilter = Carbon::today();
                        $patientVisits->whereDate($filterDateColumn, $dateFilter);
                        break;
                    case 'yesterday':
                        $dateFilter = Carbon::yesterday();
                        $patientVisits->whereDate($filterDateColumn, $dateFilter);
                        break;
                    case 'this week':
                        $dateFrom = Carbon::now()->startOfWeek();
                        $dateTo = Carbon::now()->endOfWeek();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last week':
                        $dayOfWeek = Carbon::today()->dayOfWeek;
                        $dateFrom = Carbon::parse(today()->subDays($dayOfWeek+6));
                        $dateTo = Carbon::parse(today()->subDays($dayOfWeek));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this month':
                        $daysInMonth = Carbon::today()->daysInMonth;
                        $dateFrom = Carbon::now()->startOfMonth();
                        $dateTo = Carbon::now()->endOfMonth();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last month':
                        $dayNow = date('d')+0;
                        $dateTo = Carbon::parse(today()->subDays($dayNow));
                        $dateFrom = Carbon::parse(today()->subDays($dayNow+(date('d', strtotime($dateTo)-1))));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this year':
                        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
                        $endOfYear   = Carbon::now()->endOfYear()->format('Y-m-d');
                        $patientVisits->whereBetween($filterDateColumn, [$startOfYear, $endOfYear]);
                        break;
                    case 'range':
                        if(PatientVisit::get()->count() > 0){
                            $dateFrom = is_null($request->get('filter_date_from')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->first()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_from'));
                            $dateTo = is_null($request->get('filter_date_to')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->latest()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_to'));
                            $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            $patientVisitsByFindings = $patientVisits->where('patient_visits.findings', '!=', null)
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
        $findingsByPatientAge->dataset("Age 1-10", "bar", $findingsByAge['1-10'])->backgroundColor('violet');
        $findingsByPatientAge->dataset("Age 11-20", "bar", $findingsByAge['11-20'])->backgroundColor('#33FF33');
        $findingsByPatientAge->dataset("Age 21-30", "bar", $findingsByAge['21-30'])->backgroundColor('blue');
        $findingsByPatientAge->dataset("Age 31-40", "bar", $findingsByAge['31-40'])->backgroundColor('yellow');
        $findingsByPatientAge->dataset("Age 41-50", "bar", $findingsByAge['41-50'])->backgroundColor('#FF6600');
        $findingsByPatientAge->dataset("Age 51-60", "bar", $findingsByAge['51-60'])->backgroundColor('#FF0000');
        $findingsByPatientAge->dataset("Age 60 above", "bar", $findingsByAge['60 above'])->backgroundColor('#990000');
        $findingsByPatientAge->options([
            'scales' => [
                'yAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Number of Patients"
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                    'gridLines' => [
                        'display' => true
                    ]
                ]],
                'xAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => "Findings"
                    ],
                    'gridLines' => [
                        'display' => true
                    ]
                ]]
            ]
        ]);
        return response()->json([
            'chart' => $findingsByPatientAge,
            'dateOption' => $request->get('filter_date_option'),
            'dateFilter' => Carbon::parse($dateFilter)->format('F d,Y'),
            'dateFrom' => Carbon::parse($dateFrom)->format('F d,Y'),
            'dateTo' => Carbon::parse($dateTo)->format('F d,Y'),
        ]);
    }

    public function filterFindingsChartAjax(Request $request)
    {
        $dateFrom = null;
        $dateTo = null;
        $dateFilter = null;
        $filterDateColumn = 'visit_date';
        
        $findingsChart = new FindingsThisMonth;
        $labels = [];
        $labelColors = [];
        $findingsChartData = [];
        $totalFindings = 0;

        foreach(Finding::get() as $finding){
            $patientVisits = PatientVisit::select('*');
            if($request->get('filter_date_option')){
                switch ($request->get('filter_date_option')) {
                    case 'today':
                        $dateFilter = Carbon::today();
                        $patientVisits->whereDate($filterDateColumn, $dateFilter);
                        break;
                    case 'yesterday':
                        $dateFilter = Carbon::yesterday();
                        $patientVisits->whereDate($filterDateColumn, $dateFilter);
                        break;
                    case 'this week':
                        $dateFrom = Carbon::now()->startOfWeek();
                        $dateTo = Carbon::now()->endOfWeek();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last week':
                        $dayOfWeek = Carbon::today()->dayOfWeek;
                        $dateFrom = Carbon::parse(today()->subDays($dayOfWeek+6));
                        $dateTo = Carbon::parse(today()->subDays($dayOfWeek));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this month':
                        $daysInMonth = Carbon::today()->daysInMonth;
                        $dateFrom = Carbon::now()->startOfMonth();
                        $dateTo = Carbon::now()->endOfMonth();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last month':
                        $dayNow = date('d')+0;
                        $dateTo = Carbon::parse(today()->subDays($dayNow));
                        $dateFrom = Carbon::parse(today()->subDays($dayNow+(date('d', strtotime($dateTo)-1))));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this year':
                        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
                        $endOfYear   = Carbon::now()->endOfYear()->format('Y-m-d');
                        $patientVisits->whereBetween($filterDateColumn, [$startOfYear, $endOfYear]);
                        break;
                    case 'range':
                        if(PatientVisit::get()->count() > 0){
                            $dateFrom = is_null($request->get('filter_date_from')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->first()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_from'));
                            $dateTo = is_null($request->get('filter_date_to')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->latest()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_to'));
                            $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            $countFindings = $patientVisits->where('findings', 'LIKE', '%'.explode('/', $finding->name)[0].'%')->where('findings', '!=', null)->get()->count();
            $totalFindings = $totalFindings + $countFindings;
        }

        foreach(Finding::get() as $i => $finding){
            $percentage = 0;
            $patientVisits = PatientVisit::select('*');
            if($request->get('filter_date_option')){
                switch ($request->get('filter_date_option')) {
                    case 'today':
                        $date = Carbon::today();
                        $patientVisits->whereDate($filterDateColumn, $date);
                        break;
                    case 'yesterday':
                        $date = Carbon::yesterday();
                        $patientVisits->whereDate($filterDateColumn, $date);
                        break;
                    case 'this week':
                        $dateFrom = Carbon::now()->startOfWeek();
                        $dateTo = Carbon::now()->endOfWeek();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last week':
                        $dayOfWeek = Carbon::today()->dayOfWeek;
                        $dateFrom = Carbon::parse(today()->subDays($dayOfWeek+6));
                        $dateTo = Carbon::parse(today()->subDays($dayOfWeek));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this month':
                        $daysInMonth = Carbon::today()->daysInMonth;
                        $dateFrom = Carbon::now()->startOfMonth();
                        $dateTo = Carbon::now()->endOfMonth();
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'last month':
                        $dayNow = date('d')+0;
                        $dateTo = Carbon::parse(today()->subDays($dayNow));
                        $dateFrom = Carbon::parse(today()->subDays($dayNow+(date('d', strtotime($dateTo)-1))));
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'this year':
                        $dateFrom = Carbon::now()->startOfYear()->format('Y-m-d');
                        $dateTo   = Carbon::now()->endOfYear()->format('Y-m-d');
                        $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        break;
                    case 'range':
                        if(PatientVisit::get()->count() > 0){
                            $dateFrom = is_null($request->get('filter_date_from')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->first()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_from'));
                            $dateTo = is_null($request->get('filter_date_to')) ? Carbon::parse(PatientVisit::orderBy($filterDateColumn, 'DESC')->latest()->value($filterDateColumn)) : Carbon::parse($request->get('filter_date_to'));
                            $patientVisits->whereBetween($filterDateColumn, [$dateFrom, $dateTo]);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            $countFindings = $patientVisits->where('findings', 'LIKE', '%'.explode('/', $finding->name)[0].'%')->where('findings', '!=', null)->get()->count();
            if($countFindings > 0 && $totalFindings > 0){
                $percentage = number_format(($countFindings / $totalFindings) * 100, 0);
                $labels[] = $finding->name . " " . $percentage . "%";
                $labelColors[] = $this->generateRandomColor($percentage);
                $findingsChartData[] = $countFindings;
            }
        }


        $findingsChart->labels($labels);
        $findingsChart->dataset('Findings', 'pie', $findingsChartData)->backgroundColor($labelColors)->color('black');
        $findingsChart->height(500);

        $findingsChart->options([
            'legend' => [
                'display' => true,
            ],
            'scales' => [
                'yAxes' => [[
                    'display' => false,
                ]],
                'xAxes' => [[
                    'display' => false,
                ]]
            ],
        ]);
        
        
        return response()->json([
            'chart' => $findingsChart,
            'dateOption' => $request->get('filter_date_option'),
            'dateFilter' => Carbon::parse($dateFilter)->format('F d,Y'),
            'dateFrom' => Carbon::parse($dateFrom)->format('F d,Y'),
            'dateTo' => Carbon::parse($dateTo)->format('F d,Y'),
        ]);
    }

    public function generateRandomColor($value)
    {
        $normalizedValue = max(0, min(100, $value));
        $hue = $normalizedValue * 3;
        $saturation = 100-$value;
        $lightness = 75-$value;
        $rgb = $this->hslToRgb($hue, $saturation, $lightness);
        $hexColor = $this->rgbToHex($rgb[0], $rgb[1], $rgb[2]);

        return $hexColor;
    }

    public function hslToRgb($h, $s, $l)
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;

        $r = $l;
        $g = $l;
        $b = $l;
        $v = ($l <= 0.5) ? ($l * (1 + $s)) : ($l + $s - $l * $s);
        
        if ($v > 0) {

            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6.0;
            $sextant = floor($h);
            $fract = $h - $sextant;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;

            switch ($sextant) {
                case 0:
                    $r = $v;
                    $g = $mid1;
                    $b = $m;
                    break;
                case 1:
                    $r = $mid2;
                    $g = $v;
                    $b = $m;
                    break;
                case 2:
                    $r = $m;
                    $g = $v;
                    $b = $mid1;
                    break;
                case 3:
                    $r = $m;
                    $g = $mid2;
                    $b = $v;
                    break;
                case 4:
                    $r = $mid1;
                    $g = $m;
                    $b = $v;
                    break;
                case 5:
                    $r = $v;
                    $g = $m;
                    $b = $mid2;
                    break;
            }
        }

        $result = [
            round($r * 255),
            round($g * 255),
            round($b * 255)
        ];

        return $result;
    }

    public function rgbToHex($r, $g, $b)
    {
        $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
        return $hex;
    }
}