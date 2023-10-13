{{-- @extends('layouts.app') --}}
@extends('adminlte.app')
@section('content')
{{-- Content Wrapper. Contains page content --}}
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Login Info</h1>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('login_infos.index') }}" method="GET" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="input-group">
                                    @if(isset($_GET['q']))
                                    <span class="input-group-prepend">
                                    <a class="btn btn-success" href="{{ route('login_infos.index') }}">View All</a>
                                    </span>
                                    @endif
                                    <input class="form-control" name="q" placeholder="Username/Status" @if(isset($_GET['q'])) value="{{$_GET['q']}}" @endif>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">@fa('fa fa-search') Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content-header --}}
    {{-- Main content --}}
    <div class="content">
	<div class="container-fluid">
		<div class="row"> {{-- second row --}}
			<div class="col">	{{-- patients table container --}}
				{{-- <patient-table></patient-table> --}}
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-sm" id="datatable">
						<thead>
							<tr>
								@if(Auth::user()->hasrole('System Administrator'))
								<th>ID</th>
								@endif
								<th>Status</th>
								<th>Date</th>
								<th>Username</th>
								{{-- <th>Password</th> --}}
								<th>IP Address</th>
								<th>Device</th>
								<th>Platform</th>
								<th>Browser</th>
								{{-- @if(Auth::user()->hasrole('System Administrator'))
								<th class="text-center">Action</th>
								@endif --}}
							</tr>
						</thead>
						<tbody>						
							@foreach ($loginInfos as $loginInfo)
							<tr>
								@if(Auth::user()->hasrole('System Administrator'))
								<td>{{ $loginInfo->id }}</td>
								@endif
								<td>{{ $loginInfo->status }}</td>
								<td>{{ date('M d, Y h:i A', strtotime($loginInfo->created_at)) }}</td>
								<td>{{ $loginInfo->username }}</td>
								{{-- <td>{{ $loginInfo->password }}</td> --}}
								<td>{{ $loginInfo->ip_address }}</td>
								<td>{{ $loginInfo->device }}</td>
								<td>{{ $loginInfo->platform }}</td>
								<td>{{ $loginInfo->browser }}</td>
							</tr>
							@endforeach
							@if (count($loginInfos) == 0)
						    <tr>
						   		<td class="text-danger text-center" colspan="10">*** Empty ***</td>
						    </tr>
						    @endif
						</tbody>
					</table>
				</div>
				{{-- <span class="justify-content-center row">{!! $loginInfos->links() !!}</span> --}}
			</div> {{-- end of patients container --}}
		</div> {{-- end of second row --}}
	</div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content --}}
</div>
{{-- /.content-wrapper --}}
@endsection