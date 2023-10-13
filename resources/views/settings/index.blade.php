@extends('adminlte.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="settings-tabs-tab" role="tablist" aria-orientation="vertical">
                        @can('settings.edit_company')
                        <a class="nav-link active" id="settings-tabs-company-tab" data-toggle="pill" href="#settings-tabs-company" role="tab" aria-controls="settings-tabs-home" aria-selected="true"><i class="fad fa-warehouse"></i> Company</a>
                        @endcan
                        @can('settings.edit_user_interface')
                        <a class="nav-link" id="settings-tabs-user-interface-tab" data-toggle="pill" href="#settings-tabs-user-interface" role="tab" aria-controls="settings-tabs-profile" aria-selected="false"><i class="fad fa-adjust"></i> User Interface</a>
                        @endcan
                        @can('settings.edit_system')
                        <a class="nav-link" id="settings-tabs-system-tab" data-toggle="pill" href="#settings-tabs-system" role="tab" aria-controls="settings-tabs-profile" aria-selected="false"><i class="fad fa-chart-network"></i> System</a>
                        @endcan
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="settings-tabs-tabContent">
                        @can('settings.edit_company')
                        <div class="tab-pane fade active show" id="settings-tabs-company" role="tabpanel" aria-labelledby="settings-tabs-company-tab">
                            @include('settings.company')
                        </div>
                        @endcan
                        @can('settings.edit_user_interface')
                        <div class="tab-pane fade" id="settings-tabs-user-interface" role="tabpanel" aria-labelledby="settings-tabs-user-interface-tab">
                            @include('settings.user_interface')
                        </div>
                        @endcan
                        @can('settings.edit_system')
                        <div class="tab-pane fade" id="settings-tabs-system" role="tabpanel" aria-labelledby="settings-tabs-system-tab">
                            @include('settings.system')
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dp-address.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('.dp-address').dpAddress()
    })
    $(document).ready(function(){
        $('#upload').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>
<script type="text/javascript">
    $(function(){
        /* var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        $('.nav-tabs a').click(function (e) {
            $(this).tab('show');
            window.location.hash = this.hash;
        }); */
        var hash = window.location.hash;
        $('.nav-tabs a[href="' + hash + '"]').tab('show');
    });
</script>
<script src="{{ asset('js/ui-settings.js') }}"></script>
@endsection
