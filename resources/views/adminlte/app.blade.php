@php
    if(Auth::user()->hasrole('Patient')){
        header('location: ' . config('app.url'));
        exit;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset(config('hospital.logo')) }}"> --}}
    <title>{{ config('app.name') }} | {{ config('app.client_name') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/dizonvisionclinic-icon.png') }}" type="image/x-icon">
    
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    {{-- <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('web fonts/fontawesome-pro-5.12.0-web/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-pro-6.4.2-web/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
    {{-- Theme style --}}
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    {{-- Mateiral Design Bootstrap --}}
    {{-- <link rel="stylesheet" href="{{ asset('plugins/MDB5-STANDARD-UI-KIT-Free-6.4.2/css/mdb.min.css') }}" rel="stylesheet"> --}}
    
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('style')
    
</head>
<body class="
    {{ Setting::ui('adminlte_darkmode') }}
    {{ Setting::ui('adminlte_header_fixed') }}
    {{ Setting::ui('adminlte_sidebar_fixed') }}
    {{ Setting::ui('adminlte_sidebar_collapsed') }}
    {{ Setting::ui('adminlte_sidebar_mini') }}
    {{ Setting::ui('adminlte_sidebar_mini_md') }}
    {{ Setting::ui('adminlte_sidebar_mini_xs') }}
    {{ Setting::ui('adminlte_footer_fixed') }}
    {{ Setting::ui('adminlte_accent_color_variant') }}
    ">
    @include('partials.loader')
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('AdminLTE-3.2.0/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div> --}}
        <!-- Navbar -->
        @include('adminlte.header')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('adminlte.sidebar')
        
        @yield('content')
        <div id="modalAjax"></div>
        <div id="modalOpenData"></div>
        <div id="tableActionModal"></div>
        @include('layouts.includes.delete')
        @include('layouts.includes.restore')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">{{ config('app.client_name') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ config('app.version') }}
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
    <div class="d-none" id="oldInput">
        @forelse (old() as $input => $value)
            @if (is_array($value))
                @foreach ($value as $arrayValue)
                    <input type="text" name="old_{{ $input }}[]" value="{{ $arrayValue }}">
                @endforeach
            @else
                <input type="text" name="old_{{ $input }}" value="{{ $value }}" data-error="{{ $errors->has($input) ? ' is-invalid' : '' }}" data-error-message="{{ $errors->first($input) }}">
            @endif
        @empty
        @endforelse
    </div>
    @if (count($errors) > 0)
        <div style="position: absolute; top: 0; right: 0; z-index: 1111">
            <div class="toast" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                    <strong class="mr-auto text-danger">Whoops!</strong>
                    {{-- <small class="text-muted">11 mins ago</small> --}}
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    {{-- There were some problems with your input. --}}
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @include('adminlte.modal_ajax_error')
    <!-- REQUIRED SCRIPTS -->
    @include('adminlte.scripts')
    @yield('script')
</body>
</html>