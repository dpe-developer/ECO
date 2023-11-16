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
	                              <th>Occupation</th>
	                           </tr>
	                        </thead>
	                        <tbody>
								@if(isset($_GET['patient_search']) || request()->get('filter') == 1)
									@forelse ($patients as $patient)
									<tr
										@can('patients.show')
											class="tr-link"
											data-href="{{ route('patients.show', $patient->id) }}"
										@endcan
									>
										<td>{{ $patient->username }}</td>
										<td>
											{{ $patient->fullname() }}
										</td>
										<td>
											{{ $patient->sex }}
										</td>
										<td>
											{{ $patient->occupation }}
										</td>
									@empty
									<tr>
										<td colspan="6" class="text-danger text-center">*** EMPTY ***</td>
									</tr>
									@endforelse
								@else
									<tr>
										<td colspan="6" class="text-info text-center">Loading <i class="fa fa-spinner fa-pulse fa-spin fa-lg"></i></td>
									</tr>
								@endif
							</tbody>
	                    </table>
					</div>
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
						<div class="form-group">
							<label>Findings:</label>
							<select name="filter_findings[]" class="form-control select2" multiple>
								@foreach ($findings as $finding)
								<option @if(request()->get('filter_doctor')) {{ in_array($finding->name, request()->get('filter_findings')) ? 'selected' : '' }} @endif value="{{ $finding->name }}">
									{{ $finding->name }}
								</option>
								@endforeach
							</select>
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
						{data: 'occupation', name: 'occupation'},
						{data: 'first_name', name: 'first_name', 'visible': false},
					],
					order: [
						[0, 'desc']
					]
				});
				$('#patientsTable tbody').on('click', 'tr', function () {
					var data = table.row( this ).data();
					window.location.href = 'patients/'+data.id;
				});
            @else
            	var table = $('#patientsTable').DataTable();
            @endif
        });
    </script>
@endsection