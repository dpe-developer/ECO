@extends('adminlte.app')
@section('style')
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Announcements</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @can('announcements.create')
                        <a class="btn bg-gradient-primary" href="{{ route('announcements.create') }}"><i class="fa fa-plus"></i> Add Announcement</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col" id="accordion" data-toggle="card-accordion-ajax">
                    @forelse ($announcements as $announcement)
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed text-dark accordion-with-badge" data-toggle="collapse" data-href="{{ route('announcements.show',  $announcement->id) }}" data-target="#announcement-{{ $announcement->id }}" href="#announcement-{{ $announcement->id }}" aria-expanded="false">
                                        <b>{{ $announcement->title }}</b>
                                        @if(UserNotification::isNotSeen('announcement', $announcement->id))
                                            <span class="right badge badge-danger new-badge">new</span>
                                        @endif
                                        <span class="float-right">
                                            {{ Carbon::parse($announcement->created_at)->format('M-d-Y') }}
                                        </span>
                                    </a>
                                </h4>
                            </div>
                            {{-- <a class="d-block accordion-with-badge" data-toggle="collapse" data-href="{{ route('announcements.show',  $announcement->id) }}" data-target="#announcement-{{ $announcement->id }}" href="#announcement-{{ $announcement->id }}">
                                <div class="card-header d-flex p-0">
                                    <h4 class="card-title p-3 text-dark">
                                        
                                    </h4>
                                    <ul class="nav nav-pills ml-auto p-2">
                                        @can('announcements.destroy')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('announcements.destroy', $announcement->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                        </li>
                                        @endcan
                                        @can('announcements.edit')
                                        <li class="nav-item">
                                            <a class="nav-link text-primary" href="{{ route('announcements.edit', $announcement->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                            </a> --}}
                            <div id="announcement-{{ $announcement->id }}" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    
                                </div>
                                <div class="card-footer text-right">
                                    @can('announcements.destroy')
                                        <a class="btn bg-gradient-danger btn-sm" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('announcements.destroy', $announcement->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                    @endcan
                                    @can('announcements.edit')
                                        <a class="btn bg-gradient-info btn-sm" href="{{ route('announcements.edit', $announcement->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @empty
                    <div class="alert alert-warning text-center">
                        *** EMPTY ***
                    </div>
                    @endforelse
                </div>
                {{-- <div class="col">
                    <table id="datatable" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                @role('System Administrator')
                                <th>ID</th>
                                @endrole
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date Created</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($announcements as $announcement)
                            <tr @unlessrole('System Administrator') @can('announcements.show') data-toggle="modal-ajax" data-target="#showAnnouncement" data-href="{{ route('announcements.show', $announcement->id) }}"  @endcan @else class="{{ $announcement->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $announcement->id }}</td>
                                @endrole
                                <td>{{ $announcement->title }}</td>
                                <td>{{ $announcement->description }}</td>
                                <td>
                                    {{ date('F d, Y h:i A', strtotime($announcement->created_at)) }}
                                </td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showAnnouncement" data-href="{{ route('announcements.show',$announcement->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        @if ($announcement->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('announcements.restore', $announcement->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('announcements.destroy', $announcement->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection