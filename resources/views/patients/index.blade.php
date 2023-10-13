{{-- @extends('layouts.app') --}}
@extends('adminlte.app')
{{-- For Back Button --}}
{{-- <a class="btn btn-primary" href="javascript:history.back()">Cancel</a>
<a class="btn btn-primary" href="{{ URL::previous() }}">Cancel</a> --}}
@section('style')
	@if(!Auth::user()->hasrole('System Administrator'))
	<style type="text/css">
		.table-hover > tbody > tr:hover {
			cursor: pointer;
		}
	</style>
	@endif
@endsection
@section('content')
  	<div class="content-wrapper">
	    <div class="content-header">
			<div class="container-fluid">
			  	<div class="row mb-2">
			  	  	<div class="col-md-6">
			  	  	  	<h1 class="m-0 text-dark">Patients</h1>
			  	  	</div>
			  	  	<div class="col-md-6 text-right">
						<button class="btn btn-{{ request()->get('filter')==1 ? 'primary' : 'default text-primary' }}" data-toggle="modal" data-target="#filterPatients"><i class="fa fa-search"></i> Search</button>
						{{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#filterPatients"><i class="fa fa-search"></i> Search</button> --}}
			  	  		@can('patients.create')
			  	  		<a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('patients.create') }}" data-target="#createPatientModal">
		                    <i class="fa fa-plus"></i>
		                    Add Patient
		                </a>
		                @endcan
			  	  	</div>
			  	</div>
			</div>
	    </div>
    	<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col">
						<table class="table table-sm table-bordered table-hover" id="patientsTable" style="width: 100%">
	                        <thead>
	                           <tr>
	                              <th>Patient ID</th>
	                              <th>Name</th>
	                              <th>Sex</th>
	                              @if(!isset($_GET['patient_search']) && is_null(request()->get('filter')))
	                              <th></th>
	                              @endif
	                              @role('System Administrator')
	                              <th></th>
	                              @endrole
	                           </tr>
	                        </thead>
	                        <tbody>
								@if(isset($_GET['patient_search']) || request()->get('filter') == 1)
									@forelse ($patients as $patient)
									<tr
										@unlessrole('System Administrator')
											@can('patients.show')
												class="tr-link"
												data-href="{{ route('patients.show', $patient->id) }}"
											@endcan
										@else 
											class="{{ $patient->trashed() ? 'table-danger' : '' }}" 
										@endunlessrole
										>
										<td>{{ $patient->username }}</td>
										<td>
											{{ $patient->first_name }}
											{{ $patient->last_name }}
										</td>
										<td>
											{{ $patient->sex }}
										</td>
										@role('System Administrator')
										<td class="text-center">
											<a href="{{ route('patients.show',$patient->id) }}"><i class="fad fa-file-user fa-lg"></i></a>
											@if ($patient->trashed())
												<a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('patients.restore', $patient->id) }}"><i class="fad fa-download fa-lg"></i></a>
											@else
												<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('patients.destroy', $patient->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
											@endif
										</td>
										@endrole
									@empty
									<tr>
										<td colspan="6" class="text-danger text-center">*** EMPTY ***</td>
									</tr>
									@endforelse
									</tr>
								@else
									<tr>
										<td colspan="6" class="text-info text-center">Loading <i class="fa fa-spinner fa-pulse fa-spin fa-lg"></i></td>
									</tr>
								@endif
							</tbody>
	                    </table>
					</div>
					{{-- @if(config('app.env') == 'local')
					@role('System Administrator')
					<div class="col-md-3">
						<div class="card">
							<div class="card-header">
								Insert Dummy Patient
							</div>
							<div class="card-body">
								<form class="form-horizontal" action="{{ route('random_identity.insert_patient') }}" method="post" enctype="multipart/form-data">
									@csrf
							        <hr>
									<div class="form-group">
										<label>Number of Patients: </label>
										<input class="form-control" type="number" name="number" max="15000" min="1" value="1">
									</div>
									<div class="form-group">
										<label>Date: </label>
										<input class="form-control" type="date" name="date_created">
									</div>
									<hr>
									<button type="submit" class="btn btn-danger">Submit</button>					
								</form>
							</div>
						</div>
					</div>	
					@endrole
					@endif --}}
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="filterPatients" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Filter</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{ route('patients.index') }}" action="GET" autocomplete="off">
					<div class="modal-body">
						<input type="hidden" name="filter" value="1">
						{{-- <div class="form-group">
							<label>Doctor:</label>
							<select name="filter_doctor[]" class="form-control select2" multiple>
								@foreach ($doctors as $doctor)
								<option @if(request()->get('filter_doctor')) {{ in_array($doctor->id, request()->get('filter_doctor')) ? 'selected' : '' }} @endif value="{{ $doctor->id }}">
									{{ $doctor->doctorName() }}
								</option>
								@endforeach
							</select>
						</div> --}}
						{{-- <div class="form-group">
							<label>Appointment Date:</label>
							<select class="form-control select2" name="filter_date_option" id="dateOption">
								<option></option>
								<option {{ request()->get('filter_date_option') ==  'today' ? 'selected' : '' }} value="today">Today</option>
								<option {{ request()->get('filter_date_option') ==  'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday</option>
								<option {{ request()->get('filter_date_option') ==  'this week' ? 'selected' : '' }} value="this week">This Week</option>
								<option {{ request()->get('filter_date_option') ==  'last week' ? 'selected' : '' }} value="last week">Last Week</option>
								<option {{ request()->get('filter_date_option') ==  'this month' ? 'selected' : '' }} value="this month">This Month</option>
								<option {{ request()->get('filter_date_option') ==  'last month' ? 'selected' : '' }} value="last month">Last Month</option>
								<option {{ request()->get('filter_date_option') ==  'range' ? 'selected' : '' }} value="range">Range</option>
							</select>
							<div class="row date-range d-none">
								<div class="col-sm-6">
									<div class="input-group input-group-compact datetimepicker" id="dateFrom" data-target-input="nearest">
										<div class="input-group-prepend" data-target="#dateFrom" data-toggle="datetimepicker">
											<span class="input-group-text">
												From
											</span>
										</div>
										<input type="text" class="form-control datetimepicker-input" data-target="#dateFrom" data-toggle="datetimepicker" name="filter_appointment_date_from" value="{{ request()->get('filter_appointment_date_from') }}">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group input-group-compact datetimepicker" id="dateTo" data-target-input="nearest">
										<div class="input-group-prepend" data-target="#dateTo" data-toggle="datetimepicker">
											<span class="input-group-text">
												To
											</span>
										</div>
										<input type="text" class="form-control datetimepicker-input" data-target="#dateTo" data-toggle="datetimepicker" name="filter_appointment_date_to" value="{{ request()->get('filter_appointment_date_to') }}">
									</div>
								</div>
							</div>
						</div> --}}
						<div class="form-group">
							<div class="checkbox">
								<div class="custom-control custom-checkbox">
									<input @if(request()->get('filter_active')) {{ request()->get('filter_active') ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_active" value="1" id="filterActive">
									<label class="custom-control-label" for="filterActive">Active</label>
								</div>
							</div>
							<div class="checkbox">
								<div class="custom-control custom-checkbox">
									<input @if(request()->get('filter_inpatient')) {{ request()->get('filter_inpatient') ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_inpatient" value="1" id="filterInpatient">
									<label class="custom-control-label" for="filterInpatient">Inpatient</label>
								</div>
							</div>
							<div class="checkbox">
								<div class="custom-control custom-checkbox">
									<input @if(request()->get('filter_outpatient')) {{ request()->get('filter_outpatient') ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_outpatient" value="1" id="filterOutpatient">
									<label class="custom-control-label" for="filterOutpatient">Outpatient</label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						@if (request()->get('filter'))
						<a href="{{ route('patients.index') }}" class="btn btn-default">Reset</a>
						@endif
						<button type="submit" class="btn btn-default text-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    {{-- @include('patients.create') --}}
@endsection
@section('script')
	<script type="application/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			@if(!isset($_GET['patient_search']) && is_null(request()->get('filter')))
				var table = $('#patientsTable').DataTable({
					// processing: true,
					serverSide: true,
					ajax: {
						url: 'patients',
						type: 'GET'
					},
					columns: [
						{data: 'username', name: 'username'},
						// {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						{
							data: 'last_name',
							render: function(data, type, row){
								return row.first_name+' '+row.last_name
							}
						},
						{data: 'sex', name: 'sex'},
						{data: 'first_name', name: 'first_name', 'visible': false},
						@role('System Administrator')
						{data: 'action', name: 'action', orderable: false, className: 'text-center'},
						@endrole
					],
					order: [
						[0, 'desc']
					]
				});
				@if(!Auth::user()->hasrole('System Administrator'))
				$('#patientsTable tbody').on('click', 'tr', function () {
					var data = table.row( this ).data();
					window.location.href = 'patients/'+data.id;
				});
				@endif
            @else
            	var table = $('#patientsTable').DataTable();
            @endif
        });
    </script>
@endsection