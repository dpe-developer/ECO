<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patients = User::select('*')->where('role_id', 4);
		if(Auth::user()->hasrole('System Administrator')){
			$patients->withTrashed();
		}
		$patients->orderBy('last_name', 'ASC');

		if(request()->ajax()) {
			return datatables()->of($patients)
			->setRowClass(function ($row) {
				return $row->trashed() ? 'table-danger' : '';
			})
			->addColumn('patientID', function($row){
				return $row->patient_id;
			})
			->addColumn('action', function($row){
				$action = '<a style="margin-right: 10px" href="'.route('patients.show', $row->id).'"><i class="fad fa-file-user fa-lg"></i></a>';
				if($row->trashed()){
					$action .= '<a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="'.route('patients.restore', $row->id).'"><i class="fad fa-download fa-lg"></i></a>';
				}else{
					$action .= '<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="'.route('patients.destroy', $row->id).'"><i class="fad fa-trash-alt fa-lg"></i></a>';
				}
				return $action;
			})
			->rawColumns(['action', 'patientID'])
			->addIndexColumn()
			->make(true);
		}else{
			if($request->get('patient_search')){
				$patients->where('patient_id', 'LIKE', '%'.$request->get('patient_search').'%')
				->orwhere(DB::raw('CONCAT(first_name," ", last_name)'), 'LIKE', '%'.$request->get('patient_search').'%');
			}
			if($request->get('filter_active')){
				$activePatientIDs = PatientVisit::where('status', 'active')->get('patient_id');
				$patients->whereIn('id', $activePatientIDs);
			}
			if($request->get('filter_outpatient')){
				$outPatientIDs = PatientVisit::where([
					['status', 'active'],
					['visit_type', '!=', 'admission']
				])->get('patient_id');
				$patients->whereIn('id', $outPatientIDs);
			}
			if($request->get('filter_inpatient')){
				$inPatientIDs = PatientVisit::where([
					['status', 'active'],
					['visit_type', 'admission']
				])->get('patient_id');
				$patients->whereIn('id', $inPatientIDs);
			}
			$data = [
				'patients' => $patients->get(),
				'doctors' => User::where('role_id', 3)->get()
			];
			return view('patients.index', $data);
		}
    }

    public function create()
    {
        return response()->json([
            'modal_content' => view('patients.create')->render()
        ]);
    }

    public function store(Request $request)
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
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $username = time();
        $email = is_null($request->get('email')) ? $username.'@dizonvizionclinic.com' : $request->get('email');
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
            'password' => Hash::make($username),
        ]);
        $patient->assignRole(4);

        return back()->with('alert-success', 'Patient successfully registered');
    }

    public function show(User $user)
    {
        $data = [
            'patient' => $user
        ];
        return view('patients.show', $data);
    }
}
