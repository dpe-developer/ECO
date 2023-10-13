@extends('adminlte.app')
@section('content')
{{-- Content Wrapper. Contains page content --}}
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">User Roles</h1>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('roles.index') }}" method="GET" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="input-group">
                                    @if(isset($_GET['q']))
                                    <span class="input-group-prepend">
                                    <a class="btn btn-success" href="{{ route('roles.index') }}">View All</a>
                                    </span>
                                    @endif
                                    <input class="form-control" name="q" placeholder="Role Name" @if(isset($_GET['q'])) value="{{$_GET['q']}}" @endif>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    @if(Auth::user()->hasrole('System Administrator'))
                                    <th>ID</th>
                                    @endif
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    @if(Auth::user()->hasrole('System Administrator'))
                                    <td>{{ $role->id }}</td>
                                    @endif
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                            {{-- <a class="btn btn-info btn-sm" href="#">Show</a> --}}
                                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default text-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @if (count($roles) == 0)
                                <tr>
                                    <td class="text-danger text-center" colspan="6">*** Empty ***</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- <span class="justify-content-center row">{!! $roles->links() !!}</span> --}}
                </div>
                @if(!isset($role_edit->id))
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Role</strong>
                        </div>
                        <div class="card-body scrollbar-primary" style="height: 450px;overflow-y: scroll;overflow-xy: hidden">
                            <form action="{{ route('roles.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label>Role Name:</label>
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" />
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <input class="form-control" type="text" name="description" />
                                </div>
                                <fieldset>
                                    <legend>Roles:</legend>
                                    @foreach($permissions as $object => $controller)
                                    <div class="form-group">
                                        <label>{{ ucfirst($object) }}:</label>
                                        <div class="row">
                                            @foreach($controller as $permission)
                                            <div class="checkbox col-md-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="roles[]" value="{{ $permission->id }}" id="role_{{ $permission->id }}" @if(in_array($permission->id, old('roles', []))) checked @endif>
                                                    <label class="custom-control-label" for="role_{{ $permission->id }}">{{ $permission->action }}</label>
                                                </div>
                                                {{-- <p-check class="p-switch p-fill" name="roles[]" value="{{ $permission->id }}" color="success" @if(in_array($permission->id, old('roles', []))) checked @endif>{{ $permission->action }}</p-check> --}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </fieldset>
                                <hr>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary btn-submit">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong>Edit Role</strong>
                        </div>
                        <div class="card-body scrollbar-primary" style="height: 450px;overflow-y: scroll;overflow-xy: hidden">
                            <form action="{{ route('roles.update', $role_edit->id) }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Role Name:</label>
                                    <input class="form-control" type="text" value="{{ $role_edit->name }}" name="name" />
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <input class="form-control" type="text" value="{{ $role_edit->description }}" name="description" />
                                </div>
                                <fieldset>
                                    <legend>Roles:</legend>
                                    @foreach($permissions as $object => $controller)
                                    <div class="form-group">
                                        <strong>{{ ucfirst($object) }}:</strong>
                                        <div class="row">
                                            @foreach($controller as $permission)
                                            <div class="checkbox col-md-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="roles[]" value="{{ $permission->id }}" id="role_{{ $permission->id }}" @if(in_array($permission->id, old('roles', $selected_permission_ids))) checked @endif>
                                                    <label class="custom-control-label" for="role_{{ $permission->id }}">{{ $permission->action }}</label>
                                                </div>
                                                {{-- <p-check class="p-switch p-fill" name="roles[]" value="{{ $permission->id }}" color="primary" @if(in_array($permission->id, old('roles', $selected_permission_ids))) checked @endif>{{ $permission->action }}</p-check> --}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </fieldset>
                                <hr>
                                <div class="form-group text-right">
                                    <a class="btn btn-default" href="{{ route('roles.index') }}">Cancel</a>
                                    <button class="btn btn-success btn-submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content --}}
</div>
{{-- /.content-wrapper --}}
@if ($errors->has('roles'))
<div class="alert alert-danger fade show action-alert text-center" role="alert">
    <strong>Please select roles</strong>
</div>
@endif
@endsection