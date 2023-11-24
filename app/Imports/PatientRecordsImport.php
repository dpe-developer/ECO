<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use App\Models\Finding;
use App\Models\PatientVisit;
use App\Models\PatientProfile\EyePrescription\EyePrescription;
use App\Models\PatientProfile\EyePrescription\EyePrescriptionData;
use Illuminate\Support\Facades\Hash;
use Carbon;

class PatientRecordsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $username = $this->generateUsername();
            $findings = explode(', ', $row['findings']);
            $patientName = explode(',', $row['patient_name']);
            $patientVisitDate = Carbon::parse($row['visit_date']);

            $patient = User::create([
                'role_id' => 4,
                'first_name' => $patientName[1] ?? "FIRST_NAME",
                'last_name' => $patientName[0] ?? "LAST_NAME",
                'sex' => 'male',
                'birthdate' => Carbon::parse($row['birthdate']),
                'address' => $row['address'],
                'occupation' => $row['occupation'],
                'contact_number' => $row['contact_number'],
                'username' => $username,
                'email' => $username.'@temp.com',
                'password' => Hash::make($username),
            ]);
            $patient->assignRole(4);

            if(count($findings) > 0){
                foreach($findings as $finding){
                    if(Finding::where('name', $finding)->doesntExist() && $finding != " "){
                        Finding::create([
                            'name' => $finding
                        ]);
                    }
                }
            }
            
            $patientVisit = PatientVisit::create([
                'patient_id' => $patient->id,
                'doctor_id' => 3,
                'status' => 'done',
                'findings' => json_encode($findings, true) == '[""]' ? null : json_encode($findings, true),
                'complaints' => $row['complaints'],
                'recommendations' => $row['recommendation'],
                'visit_date' => $patientVisitDate,
                'session_start' => $patientVisitDate,
                'session_end' => $patientVisitDate,
            ]);

            $eyePrescription = EyePrescription::create([
                'patient_id' => $patient->id,
                'visit_id' => $patientVisit->id,
                'doctor_id' => 3,
            ]);
            $OLDRX_parent = EyePrescriptionData::create([
                'eye_prescription_id' => $eyePrescription->id,
                'parent_id' => null,
                'child_id' => null,
                'type' => 'parent',
                'name' => 'Old RX',
            ]);
            EyePrescriptionData::insert([
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $OLDRX_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OD',
                    'description' => null,
                    'value' => $row['oldrx_od'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $OLDRX_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OS',
                    'description' => null,
                    'value' => $row['oldrx_os'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $OLDRX_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OU',
                    'description' => null,
                    'value' => $row['oldrx_ou'] ?? null,
                ],
            ]);
            $VAB_parent = EyePrescriptionData::create([
                'eye_prescription_id' => $eyePrescription->id,
                'parent_id' => null,
                'child_id' => null,
                'type' => 'parent',
                'name' => 'VA Near',
            ]);
            EyePrescriptionData::insert([
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAB_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OD',
                    'description' => null,
                    'value' => $row['vab_od'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAB_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OS',
                    'description' => null,
                    'value' => $row['vab_os'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAB_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OU',
                    'description' => null,
                    'value' => $row['vab_ou'] ?? null,
                ],
            ]);
            $VAH_parent = EyePrescriptionData::create([
                'eye_prescription_id' => $eyePrescription->id,
                'parent_id' => null,
                'child_id' => null,
                'type' => 'parent',
                'name' => 'VA Far',
            ]);
            EyePrescriptionData::insert([
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAH_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OD',
                    'description' => null,
                    'value' => $row['vah_od'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAH_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OS',
                    'description' => null,
                    'value' => $row['vah_os'] ?? null,
                ],
                [
                    'eye_prescription_id' => $eyePrescription->id,
                    'parent_id' => $VAH_parent->id,
                    'child_id' => null,
                    'type' => 'text',
                    'name' => 'OU',
                    'description' => null,
                    'value' => $row['vah_ou'] ?? null,
                ],
            ]);
        }
    }

    public function generateUsername()
    {
        $username = time();
        if(User::where('username', $username)->exists()){
            return $this->generateUsername();
        }
        return $username;
    }
}
