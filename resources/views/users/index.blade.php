{{-- @extends('layouts.app') --}}
@extends('adminlte.app')
@section('content')
{{-- @if(isset($user_edit->id))
@include('users.edit')
@else
@can('users.create')
@include('users.create')
@endcan
@endif --}}
{{-- Content Wrapper. Contains page content --}}
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div>
                <div class="col-md-6 text-right">
                    {{-- <form action="{{ route('users.index') }}" method="GET" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="input-group">
                                    @if(isset($_GET['q']))
                                    <span class="input-group-prepend">
                                    <a class="btn btn-success" href="{{ route('users.index') }}">View All</a>
                                    </span>
                                    @endif
                                    <input class="form-control" name="q" placeholder="Username/Employee ID/Last Name" @if(isset($_GET['q'])) value="{{$_GET['q']}}" @endif>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    @hasrole('System Administrator')
                    <a class="btn btn-default text-primary" href="{{ route('login_infos.index') }}"><i class="fa fa-file"></i> Logs</a>
                    @endhasrole
                    @can('users.create')
                    <button class="btn btn-default text-primary" data-href="{{ route('users.create') }}" type="button" data-toggle="modal-ajax" data-target="#addUser"><i class="fa fa-plus"></i> Add</button>
                    @endcan
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
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="datatable">
                            <thead>
                                <tr>
                                    @role('System Administrator')
                                    <th>ID</th>
                                    @endrole
                                    <th>Role</th>
                                    <th>Date Registered</th>
                                    {{-- <th>Employee ID</th>
                                    <th>Name</th> --}}
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    @role('System Administrator')
                                    <th class="text-center">Action</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr @unlessrole('System Administrator') @can('users.show') data-toggle="tr-link" data-href="{{ route('users.show', $user->id) }}"  @endcan @else class="{{ $user->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @if(Auth::user()->hasrole('System Administrator'))
                                <td>
                                    {{ $user->id }}
                                </td>
                                @endif
                                <td>{{ $user->role->role->name ?? "" }}</td>
                                <td>{{ date('F d, Y', strtotime($user->created_at)) }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="{{ route('users.show',$user->id) }}"><i class="fad fa-file-user fa-lg"></i></a>
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editUser" data-href="{{ route('users.edit',$user->id) }}"><i class="fad fa-edit fa-lg"></i></a>
                                        @if ($user->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            @if($user->id != 1)
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                            @endif
                                        @endif
                                    </td>
                                @endrole
                                </tr>
                                @endforeach
                                @if (count($users) == 0)
                                <tr>
                                    <td class="text-danger text-center" colspan="6">*** Empty ***</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- <span class="justify-content-center row">{!! $users->links() !!}</span> --}}
                </div>
            </div>
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content --}}
</div>
{{-- /.content-wrapper --}}
@endsection