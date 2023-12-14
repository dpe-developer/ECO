@extends('adminlte.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6 text-right">
					@can('users.edit')
						<a class="btn bg-gradient-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editUser" data-href="{{ route('users.edit', $user->id) }}"><i class="fad fa-edit"></i> Edit</a>
					@endcan
					@if ($user->trashed())
						@can('users.restore')
						<a class="btn bg-gradient-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@endif
                    @can('users.destroy')
                    <a class="btn bg-gradient-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                    @endcan
                    <a href="{{ route('users.index') }}" class="btn bg-gradient-secondary"><i class="fad fa-arrow-left"></i> Back</a>
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol> --}}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/'.$user->getAvatar()) }}" alt="User profile picture" />
                            </div>
                            <h3 class="profile-username text-center">{!! $user->fullname('f-m-l') !!}</h3>
                            <p class="text-muted text-center">{{ $user->role->role->name ?? "N/A" }}</p>
                            {{-- <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item"><b>Followers</b> <a class="float-right">1,322</a></li>
                                <li class="list-group-item"><b>Following</b> <a class="float-right">543</a></li>
                                <li class="list-group-item"><b>Friends</b> <a class="float-right">13,287</a></li>
                            </ul> --}}
                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">
                                {{ $user->email }}
                            </p>
                            {{-- <hr />
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">Malibu, California</p>
                            <hr />
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>
                            <hr />
                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills profile-customize-ui">
                                {{-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li> --}}
                                <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Timeline</a></li>
								@if(Setting::system('users_can_customize_ui') == 1 || Auth::user()->hasrole('System Administrator'))
                                {{-- @if(Auth::user()->id == $user->id) --}}
                                <li class="nav-item"><a class="nav-link" href="#customize-ui" data-toggle="tab">Customize UI</a></li>
								{{-- @endif --}}
								@endif
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="timeline">
									<div class="timeline timeline-inverse">
									@foreach($user->loginInfos() as $date => $loginInfos)
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-info">
                                                {{ $date == Date('F d, Y') ? 'Today' : $date }}
                                            </span>
                                        </div>
										@foreach($loginInfos as $loginInfo)
										<div>
											@if($loginInfo->status == 'success')
                                            <i class="fas fa-sign-in bg-success"></i>
											@else
                                            <i class="fas fa-exclamation bg-danger"></i>
											@endif
                                            {{-- <i class="fas fa-check bg-success"></i> --}}
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ date('h:ia', strtotime($loginInfo->created_at)) }}</span>
                                                {{-- <h3 class="timeline-header"><a href="#">Login</a> sent you an email</h3> --}}
                                                <h3 class="timeline-header">{{ ucfirst($loginInfo->status) }} Login</h3>
                                                <div class="timeline-body">
                                                    <ul>
														<li>
															<b>Platform: </b> {{ $loginInfo->platform }}
														</li>
														<li>
															<b>Browser: </b> {{ $loginInfo->browser }}
														</li>
													</ul>
                                                </div>
                                                {{-- <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div> --}}
                                            </div>
                                        </div>
										@endforeach
									@endforeach
									</div>
                                    <!-- The timeline -->
                                    {{-- <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                10 Feb. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-envelope bg-primary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                                <div class="timeline-body">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo
                                                    kaboodle quora plaxo ideeli hulu weebly balihoo...
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                                <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-comments bg-warning"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                                <div class="timeline-body">
                                                    Take me to your leader! Switzerland is small and neutral! We are more like Germany, ambitious and misunderstood!
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-success">
                                                3 Jan. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-camera bg-purple"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                                                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                                <div class="timeline-body">
                                                    <img src="https://placehold.it/150x100" alt="..." />
                                                    <img src="https://placehold.it/150x100" alt="..." />
                                                    <img src="https://placehold.it/150x100" alt="..." />
                                                    <img src="https://placehold.it/150x100" alt="..." />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div> --}}
                                </div>
                                <!-- /.tab-pane -->
								@if(Setting::system('users_can_customize_ui') == 1  || Auth::user()->hasrole('System Administrator'))
                                {{-- @if(Auth::user()->id == $user->id) --}}
                                <div class="tab-pane" id="customize-ui">
                                    @hasrole('System Administrator')
                                    @if(Setting::system('users_can_customize_ui') == 0)
                                    <div class="alert alert-info {{-- alert-dismissible --}}">
                                        {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
                                        <b class="text-lg"><i class="icon fas fa-info"></i></b>
                                        Users cannot customize their UI.
                                    </div>
                                    @endif
                                    @endhasrole
                                    @if(count($userInterfaceSetting) > 0)
                                    <form id="userInterfaceSettingsForm" action="{{ route('users.edit_user_interface') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <a href="{{ route('users.reset_user_interface') }}" class="btn btn-default text-info"><i class="fad fa-undo"></i> Reset</a>
                                                <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                        <div class="ui-options">
                                            <div class="form-group">
                                                <input type="hidden" name="adminlte_darkmode" value="">
                                                <input id="darkmode" type="checkbox" name="adminlte_darkmode" @if($userInterfaceSetting['adminlte_darkmode'] == 'dark-mode') checked @endif data-bootstrap-switch value="dark-mode">
                                                <label for="darkmode">Dark Mode</label>
                                            </div>
                                            <legend>
                                                Header Options
                                            </legend>
                                            <div class="form-group ml-3">
                                                <input type="hidden" name="adminlte_header_fixed" value="">
                                                <input id="headerFixed" type="checkbox" name="adminlte_header_fixed" @if($userInterfaceSetting['adminlte_header_fixed'] == 'layout-navbar-fixed') checked @endif data-bootstrap-switch value="layout-navbar-fixed">
                                                <label for="headerFixed">Fixed</label>
                                                <br>
                                                <input type="hidden" name="adminlte_header_dropdown_legacy_offset" value="">
                                                <input id="headerDropdownLegacy" type="checkbox" name="adminlte_header_dropdown_legacy_offset" @if($userInterfaceSetting['adminlte_header_dropdown_legacy_offset'] == 'dropdown-legacy') checked @endif data-bootstrap-switch value="dropdown-legacy">
                                                <label for="headerDropdownLegacy">Dropdown Legacy</label>
                                                <br>
                                                <input type="hidden" name="adminlte_header_no_border" value="">
                                                <input id="headerNoBorder" type="checkbox" name="adminlte_header_no_border" @if($userInterfaceSetting['adminlte_header_no_border'] == 'border-bottom-0') checked @endif data-bootstrap-switch value="border-bottom-0">
                                                <label for="headerNoBorder">No Border</label>
                                            </div>
                                            <legend>
                                                Sidebar Options
                                            </legend>
                                            <div class="form-group ml-3">
                                                <input type="hidden" name="adminlte_sidebar_collapsed" value="">
                                                <input id="sidebarCollapse" type="checkbox" name="adminlte_sidebar_collapsed" @if($userInterfaceSetting['adminlte_sidebar_collapsed'] == 'sidebar-collapse') checked @endif data-bootstrap-switch value="sidebar-collapse">
                                                <label for="sidebarCollapse">Collapse</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_fixed" value="">
                                                <input id="sidebarFixed" type="checkbox" name="adminlte_sidebar_fixed" @if($userInterfaceSetting['adminlte_sidebar_fixed'] == 'layout-fixed') checked @endif data-bootstrap-switch value="layout-fixed">
                                                <label for="sidebarFixed">Fixed</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_mini" value="">
                                                <input id="sidebarMini" type="checkbox" name="adminlte_sidebar_mini" @if($userInterfaceSetting['adminlte_sidebar_mini'] == 'sidebar-mini') checked @endif data-bootstrap-switch value="sidebar-mini">
                                                <label for="sidebarMini">Sidebar Mini</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_mini_md" value="">
                                                <input id="sidebarMiniMd" type="checkbox" name="adminlte_sidebar_mini_md" @if($userInterfaceSetting['adminlte_sidebar_mini_md'] == 'sidebar-mini-md') checked @endif data-bootstrap-switch value="sidebar-mini-md">
                                                <label for="sidebarMiniMd">Sidebar Mini MD</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_mini_xs" value="">
                                                <input id="sidebarMiniXs" type="checkbox" name="adminlte_sidebar_mini_xs" @if($userInterfaceSetting['adminlte_sidebar_mini_xs'] == 'sidebar-mini-xs') checked @endif data-bootstrap-switch value="sidebar-mini-xs">
                                                <label for="sidebarMiniXs">Sidebar Mini XS</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_nav_flat_style" value="">
                                                <input id="sidebarNavFlatStyle" type="checkbox" name="adminlte_sidebar_nav_flat_style" @if($userInterfaceSetting['adminlte_sidebar_nav_flat_style'] == 'nav-flat') checked @endif data-bootstrap-switch value="nav-flat">
                                                <label for="sidebarNavFlatStyle">Nav Flat Style</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_nav_legacy_style" value="">
                                                <input id="sidebarNavLegacyStyle" type="checkbox" name="adminlte_sidebar_nav_legacy_style" @if($userInterfaceSetting['adminlte_sidebar_nav_legacy_style'] == 'nav-legacy') checked @endif data-bootstrap-switch value="nav-legacy">
                                                <label for="sidebarNavLegacyStyle">Nav Legacy Style</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_nav_child_indent" value="">
                                                <input id="sidebarNavChildIndent" type="checkbox" name="adminlte_sidebar_nav_child_indent" @if($userInterfaceSetting['adminlte_sidebar_nav_child_indent'] == 'nav-child-indent') checked @endif data-bootstrap-switch value="nav-child-indent">
                                                <label for="sidebarNavChildIndent">Nav Child Indent</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_nav_child_hide_on_collapse" value="">
                                                <input id="sidebarNavCollapseChildHide" type="checkbox" name="adminlte_sidebar_nav_child_hide_on_collapse" @if($userInterfaceSetting['adminlte_sidebar_nav_child_hide_on_collapse'] == 'nav-collapse-hide-child') checked @endif data-bootstrap-switch value="nav-collapse-hide-child">
                                                <label for="sidebarNavCollapseChildHide">Nav Child Hide on Collapse</label>
                                                <br>
                                                <input type="hidden" name="adminlte_sidebar_disable_hover_focus_auto_expand" value="">
                                                <input id="sidebarNoExpand" type="checkbox" name="adminlte_sidebar_disable_hover_focus_auto_expand" @if($userInterfaceSetting['adminlte_sidebar_disable_hover_focus_auto_expand'] == 'sidebar-no-expand') checked @endif data-bootstrap-switch value="sidebar-no-expand">
                                                <label for="sidebarNoExpand">Disable Hover/Focus Auto-Expand</label>
                                            </div>
                                            <legend>
                                                Footer Options
                                            </legend>
                                            <div class="form-group ml-3">
                                                <input type="hidden" name="adminlte_footer_fixed" value="">
                                                <input id="footerFixed" type="checkbox" name="adminlte_footer_fixed" @if($userInterfaceSetting['adminlte_footer_fixed'] == 'layout-footer-fixed') checked @endif data-bootstrap-switch value="layout-footer-fixed">
                                                <label for="footerFixed">Fixed</label>
                                            </div>
                                            <legend>
                                                Small Text Options
                                            </legend>
                                            <div class="form-group ml-3">
                                                <input type="hidden" name="adminlte_small_text_body" value="">
                                                <input id="smallTextBody" type="checkbox" name="adminlte_small_text_body" @if($userInterfaceSetting['adminlte_small_text_body'] == 'text-sm') checked @endif data-bootstrap-switch value="text-sm">
                                                <label for="smallTextBody">Body</label>
                                                <br>
                                                <input type="hidden" name="adminlte_small_text_navbar" value="">
                                                <input id="smallTextNavbar" type="checkbox" name="adminlte_small_text_navbar" @if($userInterfaceSetting['adminlte_small_text_navbar'] == 'text-sm') checked @endif data-bootstrap-switch value="text-sm">
                                                <label for="smallTextNavbar">Navbar</label>
                                                <br>
                                                <input type="hidden" name="adminlte_small_text_brand" value="">
                                                <input id="smallTextBrand" type="checkbox" name="adminlte_small_text_brand" @if($userInterfaceSetting['adminlte_small_text_brand'] == 'text-sm') checked @endif data-bootstrap-switch value="text-sm">
                                                <label for="smallTextBrand">Brand</label>
                                                <br>
                                                <input type="hidden" name="adminlte_small_text_sidebar_nav" value="">
                                                <input id="smallTextSidebarNav" type="checkbox" name="adminlte_small_text_sidebar_nav" @if($userInterfaceSetting['adminlte_small_text_sidebar_nav'] == 'text-sm') checked @endif data-bootstrap-switch value="text-sm">
                                                <label for="smallTextSidebarNav">Sidebar Nav</label>
                                                <br>
                                                <input type="hidden" name="adminlte_small_text_footer" value="">
                                                <input id="smallTextFooter" type="checkbox" name="adminlte_small_text_footer" @if($userInterfaceSetting['adminlte_small_text_footer'] == 'text-sm') checked @endif data-bootstrap-switch value="text-sm">
                                                <label for="smallTextFooter">Footer</label>
                                            </div>
                                            <div class="sidebar-variants"></div>
                                        </div>
                                        <input type="hidden" readonly name="adminlte_navbar_variant" value="{{ $userInterfaceSetting['adminlte_navbar_variant'] }}" />
                                        <input type="hidden" readonly name="adminlte_accent_color_variant" value="{{ $userInterfaceSetting['adminlte_accent_color_variant'] }}" />
                                        <input type="hidden" readonly name="adminlte_sidebar_variant" value="{{ $userInterfaceSetting['adminlte_sidebar_variant'] }}" />
                                        <input type="hidden" readonly name="adminlte_brand_logo_variant" value="{{ $userInterfaceSetting['adminlte_brand_logo_variant'] }}" />
                                    </form>
                                    @else
                                    <div class="alert alert-warning {{-- alert-dismissible --}}">
                                        {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
                                        <b class="text-lg"><i class="icon fas fa-exclamation"></i></b>
                                        This User cannot customize UI.
                                        @hasrole('System Administrator')
                                        <code>userInterfaceSetting</code> data not found in the database.
                                        <a class="text-primary" href="{{ route('settings.index', ['#settings-tabs-user-interface']) }}">Go to UI Settings</a>
                                        @endhasrole
                                    </div>
                                    @endif
                                </div>
								{{-- @endcan --}}
								@endcan
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript">
    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>
<script src="{{ asset('js/ui-settings.js') }}"></script>
@endsection