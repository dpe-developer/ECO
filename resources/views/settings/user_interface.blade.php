<form id="userInterfaceSettingsForm" action="{{ route('settings.edit_user_interface') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
		<div class="col-md-8">
			<h3>User Interface Settings</h3>
		</div>
		<div class="col-md-4 text-right">
			<button type="button" class="btn btn-default text-info" data-toggle="modal" data-target="#userInterfaceSettingsResetModal"><i class="fad fa-undo"></i> Reset</button>
			<button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
		</div>
	</div>
	<hr>
    @hasrole('System Administrator')
    @if(Setting::system('users_can_customize_ui') == 0)
    <div class="alert alert-info {{-- alert-dismissible --}}">
        {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
        <b class="text-lg"><i class="icon fas fa-info"></i></b>
        Users cannot customize their UI. Settings below are set globally.
    </div>
    @endif
    @endhasrole
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
<div class="modal fade" id="userInterfaceSettingsResetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-warning">@fa('fa fa-exclamation-triangle fa-lg') Alert</h4>
                <a href="javascript:void(0)" class="close" aria-hidden="true" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <p class="text-left">
                    Are you sure do you want to <strong class="text-warning">RESET</strong> UI Settings to default?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{{ route('settings.reset_user_interface') }}" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>