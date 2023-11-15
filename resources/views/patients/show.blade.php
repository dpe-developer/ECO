@extends('adminlte.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Patient Profile</h1>
                </div>
                <div class="col-md-6 text-right">
                    @if ($patient->trashed())
						@can('patients.restore')
						<a class="btn bg-gradient-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('patients.restore', $patient->id) }}"><i class="fas fa-download"></i> Restore</a>
						@endcan
					@else
						@can('patients.destroy')
						<a class="btn bg-gradient-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('patients.destroy', $patient->id) }}" data-message="This will also delete all the records of the patient."><i class="fas fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
                    @can('patients.edit')
                        <a class="btn bg-gradient-info" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('patients.edit', $patient->id) }}" data-target="#editPatientModal"><i class="fa fa-edit"></i> Edit</a>
                    @endcan
                    <a class="btn bg-gradient-secondary" href="{{ route('patients.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        {{-- Patient Info --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header" data-card-widget="collapse" style="cursor: pointer">
                        <h2 class="card-title">
                            <strong>{{ $patient->username }}</strong> -
                            {!! $patient->fullname() !!}
                        </h2>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body" id="profile">
                        <div class="row patient-info">
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <img class="img-thumbnail patient-avatar" src="{{ asset($patient->getAvatar()) }}" width="100%" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mb-0">
                                    <label>Patient ID:</label>
                                    {{ $patient->username }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>First Name:</label>
                                    {{ $patient->first_name }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Last Name:</label>
                                    {{ $patient->last_name }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Sex:</label>
                                    {{ $patient->sex }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Age:</label>
                                    {{ $patient->age() }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Date of Birth:</label> 
                                    {{ Carbon::parse($patient->birthdate)->format('M d,Y') }}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group mb-0 form-group mb-0-clean">
                                    <label>Address:</label>
                                    {{ $patient->address }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Contact #:</label>
                                    {{ $patient->contact_number }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Email:</label>
                                    {{ $patient->email }}
                                </div>
                                <div class="form-group mb-0">
                                    <label>Occupation:</label>
                                    {{ $patient->occupation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($patient->hasActiveVisit())
            @include('patients.patient_profile.patient_visits.active')
        @endif
        {{-- Medical Records --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs {{-- patient-profile-tab --}}" id="patient-profile-tab" role="tablist">
                            @can('patient_visits.index')
                            <li class="nav-item">
                                <a class="nav-link active" id="visits-tab" data-toggle="tab" href="#nav-visits" role="tab" aria-controls="nav-visits" aria-selected="true">Visits</a>
                            </li>
                            @endcan
                            @can('appointments.index')
                            <li class="nav-item">
                                <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#nav-appointments" role="tab" aria-controls="nav-appointments" aria-selected="false">Appointments</a>
                            </li>
                            @endcan
                            @can('medical_histories.index')
                            <li class="nav-item">
                                <a class="nav-link" id="medical-histories-tab" data-toggle="tab" href="#nav-medical-histories" role="tab" aria-controls="nav-medical-histories" aria-selected="false">Medical Histories</a>
                            </li>
                            @endcan
                            @can('complaints.index')
                            <li class="nav-item">
                                <a class="nav-link" id="complaints-tab" data-toggle="tab" href="#nav-complaints" role="tab" aria-controls="nav-complaints" aria-selected="false">{{ trans('terminologies.complaints') }}</a>
                            </li>
                            @endcan
                            @can('eye_prescriptions.index')
                            <li class="nav-item">
                                <a class="nav-link" id="eye-prescriptions-tab" data-toggle="tab" href="#nav-eye-prescriptions" role="tab" aria-controls="nav-eye-prescriptions" aria-selected="false">{{ trans('terminologies.eye_prescriptions') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="nav-tabContent">
                            @can('patient_visits.index')
                            <div class="tab-pane fade show active" id="nav-visits" role="tabpanel" aria-labelledby="visits-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('patients.patient_profile.patient_visits.index')
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('appointments.index')
                            <div class="tab-pane fade" id="nav-appointments" role="tabpanel" aria-labelledby="appointments-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('patients.patient_profile.appointments.index')
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('medical_histories.index')
                            <div class="tab-pane fade" id="nav-medical-histories" role="tabpanel" aria-labelledby="medical-histories-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('patients.patient_profile.medical_histories.index')
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('complaints.index')
                            <div class="tab-pane fade" id="nav-complaints" role="tabpanel" aria-labelledby="complaints-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('patients.patient_profile.complaints.index')
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('eye_prescriptions.index')
                            <div class="tab-pane fade" id="nav-eye-prescriptions" role="tabpanel" aria-labelledby="eye-prescriptions-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('patients.patient_profile.eye_prescriptions.index')
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    @yield('active_visit_styles')
@endsection
@section('script')
    @yield('active_visit_scripts')
@endsection