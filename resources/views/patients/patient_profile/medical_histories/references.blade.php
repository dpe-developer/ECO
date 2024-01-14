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
                    <h1 class="m-0 text-dark">Medical History References</h1>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('medical_history_references.index') }}" method="GET" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="input-group">
                                    @if(isset($_GET['q']))
                                    <span class="input-group-prepend">
                                    <a class="btn btn-success" href="{{ route('medical_history_references.index') }}">View All</a>
                                    </span>
                                    @endif
                                    <input class="form-control" name="q" placeholder="Reference Name" @if(isset($_GET['q'])) value="{{$_GET['q']}}" @endif>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">@fa('fa fa-search') Search</button>
                                    </div>
                                </div>
                            </div>
                            @can('medical_history_references.create')
                            <div class="form-group col-2">
                                <button class="btn btn-default text-primary" type="button" data-toggle="modal-ajax" data-href="{{ route('medical_history_references.create') }}" data-target="#addPatientProfileReference"><i class="fa fa-plus"></i> Add</button>
                            </div>
                            @endcan
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
				<div class="col"> {{-- table container --}}
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-sm" id="">
							<thead>
								<tr>
									@if (Auth::user()->hasrole('System Administrator'))
									<th>ID</th>
									@endif
									<th>Reference Name</th>
									<th>Type</th>
									<th>Description</th>
									@if (Auth::user()->hasrole('System Administrator'))
									<th class="text-center">Action</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($references as $reference)
									@if($reference->children->count())
										<tr 
                                            @unlessrole('System Administrator')
                                                @can('medical_history_references.edit')
                                                    data-toggle="modal-ajax"
                                                    data-href="{{ route('medical_history_references.edit', $reference->id) }}"
                                                    data-target="#editPatientProfileReference" 
                                                @endcan
                                            @endunlessrole
                                        	>
											@if (Auth::user()->hasrole('System Administrator'))
											<td>{{ $reference->id }}</td>
											@endif
											<th>
												{{ $reference->name }}:<br>
												@if($reference->description != null)({{ $reference->description }})@endif
											</th>
											<th>Type</th>
											<th>Description</th>
											@role('System Administrator')
                                            <td class="text-center">
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPatientProfileReference" data-href="{{ route('medical_history_references.edit',$reference->id) }}"><i class="fad fa-edit fa-lg"></i></a>
												<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('medical_history_references.destroy', $reference->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                            </td>
                                            @endrole
										</tr> {{-- end of reference w/ child --}}
										@foreach ($reference->children as $child)
											@if($child->child_id==null)
												<tr 
													@unlessrole('System Administrator')
														@can('medical_history_references.edit')
															data-toggle="modal-ajax"
															data-href="{{ route('medical_history_references.edit', $child->id) }}"
															data-target="#editPatientProfileReference" 
														@endcan
													@endunlessrole
													>
													@if (Auth::user()->hasrole('System Administrator'))
													<td>{{ $child->id }}</td>
													@endif
													<td style="padding-left: 30px">
														<li>{{ $child->name}}</li>
													</td>
													<td>{{ $child->type($child->type)}}</td>
													<td>{{ $child->description}}</td>
													@role('System Administrator')
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPatientProfileReference" data-href="{{ route('medical_history_references.edit',$child->id) }}"><i class="fad fa-edit fa-lg"></i></a>
														<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('medical_history_references.destroy', $child->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                                    </td>
                                                    @endrole
												</tr> {{-- end of child reference w/out children --}}
											@endif
											@if ($child->child->count())
												@foreach ($child->child as $children)
													<tr @if(Auth::user()->role_id != 1) @can('medical_history_references.edit') class="tr-link" data-href="{{ route('medical_history_references.edit', $children->id) }}" @endcan @endif> {{-- child children --}}
														@if (Auth::user()->hasrole('System Administrator'))
														<td>{{ $children->id }}</td>
														@endif
														<td  style="padding-left: 60px">- {{ $children->name}}</td>
														<td>{{ $children->type($children->type) }}</td>
														<td>{{ $children->description }}</td>
														@role('System Administrator')
														<td class="text-center">
															<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPatientProfileReference" data-href="{{ route('medical_history_references.edit',$children->id) }}"><i class="fad fa-edit fa-lg"></i></a>
															<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('medical_history_references.destroy', $children->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
														</td>
														@endrole
													</tr> {{-- end of child children --}}
												@endforeach
											@endif
										@endforeach
									@else
										<tr 
                                            @unlessrole('System Administrator')
                                                @can('medical_history_references.edit')
                                                    data-toggle="modal-ajax"
                                                    data-href="{{ route('medical_history_references.edit', $reference->id) }}"
                                                    data-target="#editPatientProfileReference" 
                                                @endcan
                                            @endunlessrole
                                        	>
											@if (Auth::user()->hasrole('System Administrator'))
											<td>{{ $reference->id }}</td>
											@endif
											<td>{{ $reference->name }}</td>
											<td>{{ $reference->type($reference->type) }}</td>
											<td>{{ $reference->description }}</td>
											@role('System Administrator')
                                            <td class="text-center">
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPatientProfileReference" data-href="{{ route('medical_history_references.edit',$reference->id) }}"><i class="fad fa-edit fa-lg"></i></a>
                                                <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('medical_history_references.destroy', $reference->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                            </td>
                                            @endrole
										</tr> {{-- end of reference w/out child --}}
									@endif
								@endforeach {{-- end of references --}}
								@if (count($references) == 0)
							    <tr>
							   		<td class="text-danger text-center" colspan="7">*** Empty ***</td>
							    </tr>
							    @endif
							</tbody>
						</table>
					</div>
					<span class="justify-content-center row">{{ $references->links() }}</span>
				</div> {{-- end of table container --}}
            </div>
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content --}}
</div>
{{-- /.content-wrapper --}}
@endsection
