<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientVisit;
use App\Models\Service;
use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class PatientController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:patients.index', ['only' => ['index']]);
		$this->middleware('permission:patients.create', ['only' => ['create','store']]);
		$this->middleware('permission:patients.show', ['only' => ['show']]);
		$this->middleware('permission:patients.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:patients.destroy', ['only' => ['destroy']]);
		$this->middleware('permission:patients.restore', ['only' => ['restore']]);
	}
	
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
			->rawColumns(['patientID'])
			->addIndexColumn()
			->make(true);
		}else{
			if($request->get('patient_search')){
				$patients->where('patient_id', 'LIKE', '%'.$request->get('patient_search').'%')
				->orwhere(DB::raw('CONCAT(first_name," ", last_name)'), 'LIKE', '%'.$request->get('patient_search').'%');
			}
            if($request->get('filter_findings')){
                $patientIDs = [];
                foreach($request->get('filter_findings') as $finding){
                    foreach(PatientVisit::where('findings', 'LIKE', '%'.$finding.'%')->get() as $patientVisit){
                        $patientIDs[] = $patientVisit->patient_id;
                    }
                }
                $patients->whereIn('id', $patientIDs);
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
				'doctors' => User::where('role_id', 3)->get(),
				'findings' => Finding::get(),
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
            'occupation' => ['string', 'max:255'],
            'contact_number' => ['string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $username = time();
        $email = is_null($request->get('email')) ? $username.'@temp.com' : $request->get('email');
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

    public function show($userID)
    {
        $user = User::select('*');
        if(Auth::user()->hasRole('System Administrator')){
            $user->withTrashed();
        }
        $data = [
            'patient' => $user->where('id', $userID)->first(),
            'services' => Service::get(),
            'findings' => Finding::get(),
        ];
        return view('patients.show', $data);
    }

	public function edit(Request $request, User $user)
    {
		$data = [
			'patient' => $user
		];
        return response()->json([
            'modal_content' => view('patients.edit', $data)->render()
        ]);
    }

	public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'string', 'max:255'],
            'occupation' => ['string', 'max:255'],
            'contact_number' => ['string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,'. $user->id],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $email = is_null($request->get('email')) ? $user->username.'@temp.com' : $request->get('email');
        $user->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'sex' => $request->get('sex'),
            'birthdate' => $request->get('birthdate'),
            'address' => $request->get('address'),
            'occupation' => $request->get('occupation'),
            'contact_number' => $request->get('contact_number'),
            'email' => $email,
        ]);

        return back()->with('alert-success', 'Patient successfully UPDATED');
    }
    
    public function destroy(User $user)
	{
        if (request()->get('permanent')) {
            $user->forceDelete();
        }else{
            $user->delete();
        }
        return redirect()->route('patients.index')->with('alert-warning', 'Patient Successfully DELETED');
	}

	public function restore($user)
	{
		$user = User::withTrashed()->find($user);
		$user->restore();
		return back()->with('alert-success', $user->username.' Successfully Restored');
		// return redirect()->route('users.index')->with('alert-success','User successfully restored');
	}
}
