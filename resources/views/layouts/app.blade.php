<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | {{ config('app.client_name') }}</title>

    {{-- App icon --}}
	<link rel="shortcut icon" href="{{ asset('images/dizonvisionclinic-icon.png') }}" type="image/x-icon">

    {{-- Fonts --}}
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-pro-6.4.2-web/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">

    {{-- Main Stylesheet --}}
    <link class="reloadable" href="{{ asset('plugins/MDB5-STANDARD-UI-KIT-Free-6.4.2/css/mdb.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('bootstrap-5.2.3/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/website-style.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light mb-1">
        <div class="container">
            <a class="navbar-brand mb-0" href="/">
                <img src="{{ asset('images/dizonvisionclinic-logo.png') }}" alt="Logo" width="45" height="45" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 main-navbar-nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('/') }}">
                            <i class="fa-solid fa-house "></i>
                            Home
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('services') }}">
                            <i class="fa-solid fa-stethoscope "></i>
                            Services
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('clinic-announcements') }}">
                            <i class="fa-solid fa-megaphone "></i>
                            Announcements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('news-feed') }}">
                            <i class="fa-solid fa-newspaper "></i>
                            Newsfeed
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('track-appointment') }}">
                            <i class="fa-solid fa-calendar-check "></i>
                            Track Appointment
                        </a>
                    </li> --}}
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('patient_appointments') }}">
                            <i class="fa-solid fa-calendar-check "></i>
                            Appointments
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('track-appointment') }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            Track Appointment
                        </a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('contact-us') }}">
                            <i class="fa-solid fa-comments "></i>
                            Contact Us
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_About" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-square-info "></i>
                            About
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown_About">
                            <li>
                                <a class="dropdown-item" href="{{ url('services') }}">Services Offered</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('gallery') }}">Gallery</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('our-story') }}">Our Story</a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="{{ url('our-organization') }}">Our Organization</a>
                            </li> --}}
                        </ul>
                    </li>
                </ul>
            </div>
            @auth
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/'.Auth::user()->getAvatar()) }}" class="rounded-circle" height="35" alt="Black and White Portrait of a Man" loading="lazy"/>
                    {{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                    @if(Auth::user()->role_id != 4)
                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @endif
                    <li>
                        <a class="dropdown-item" href="{{ route('my-profile', Auth::user()->username) }}">My profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('patient_appointments.index') }}">Appointments</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
            @else
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" style="color: #0098da" aria-current="page" href="#" data-mdb-toggle="modal" data-mdb-target="#modalLogin">
                        <i class="fa-solid fa-right-to-bracket "></i>
                        Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #0098da" aria-current="page" href="{{ route('register') }}">
                        Sign Up
                    </a>
                </li>
            </ul>
            @endif
            {{-- <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer class="text-center text-lg-start bg-white text-muted" style="border-top: 5px solid #0098da;">
        {{-- Section: Social media --}}
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            {{-- Left --}}
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            {{-- Left --}}
    
            {{-- Right --}}
            <div>
                <a class="btn text-white me-4" style="background-color: #3b5998;" href="https://www.facebook.com/dizonopticalvisiontherapyclinic" role="button">
                    <i class="fab fa-facebook-f"></i>
                </a>
                {{--
                <a href="https://www.facebook.com/dizonopticalvisiontherapyclinic" target="_blank" class="me-4 link-secondary">
                    <i class="fab fa-facebook-f"></i>
                </a>
                --}} {{--
                <a href="" class="me-4 link-secondary">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 link-secondary">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 link-secondary">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 link-secondary">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 link-secondary">
                    <i class="fab fa-github"></i>
                </a>
                --}}
            </div>
            {{-- Right --}}
        </section>
        {{-- Section: Social media --}}
        {{-- Section: Links  --}}
        <section class="">
            <div class="container text-center text-md-start mt-5">
                {{-- Grid row --}}
                <div class="row mt-3">
                    {{-- Grid column --}}
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        {{-- Content --}}
                        <h6 class="text-uppercase fw-bold mb-4"><img src="{{ asset('storage/images/dizonvisionclinic-logo.png') }}" width="100" />{{ config('app.client_name') }}</h6>
                        {{-- <p>
                            Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        </p> --}}
                    </div>
                    {{-- Grid column --}}
    
                    {{-- Grid column --}}
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        {{-- Links --}}
                        <h6 class="text-uppercase fw-bold mb-4">
                            Partners
                        </h6>
                        <p>
                            <a href="https://laravel.com/" class="text-reset">Laravel</a>
                        </p>
                    </div>
                    {{-- Grid column --}}
    
                    {{-- Grid column --}}
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        {{-- Links --}}
                        <h6 class="text-uppercase fw-bold mb-4">
                            Quick links
                        </h6>
                        <p>
                            <a href="our-story" class="text-reset">Our Story</a>
                        </p>
                        <p>
                            <a href="announcements" class="text-reset">Announcements</a>
                        </p>
                        <p>
                            <a href="contact-us" class="text-reset">Contact Us</a>
                        </p>
                    </div>
                    {{-- Grid column --}}
    
                    {{-- Grid column --}}
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        {{-- Links --}}
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3 text-secondary"></i> Located at 4th Floor Porta Vaga Mall, Session Road, Baguio City</p>
                        <p>
                            <i class="fas fa-envelope me-3 text-secondary"></i>
                            drjunncdizon@yahoo.com
                        </p>
                        <p><i class="fas fa-phone me-3 text-secondary"></i> (63) 9176721925</p>
                    </div>
                    {{-- Grid column --}}
                </div>
                {{-- Grid row --}}
            </div>
        </section>
        {{-- <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);"> --}}
        <div class="text-center p-4" style="background-color: #b7e3f991;">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="/">{{ config('app.client_name') }}</a>
        </div>
        {{-- Copyright --}}
    </footer>

    {{-- Modal --}}
    <div id="modalAjax"></div>
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Login</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-outline mb-4">
                        <input type="text" name="username" id="inputLoginUsernameEmail" class="form-control" required />
                        <label class="form-label" for="inputLoginUsernameEmail">Username/Email</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="inputLoginPassword" class="form-control" />
                        <label class="form-label" for="inputLoginPassword">Password</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="checkboxLoginRemember" />
                                <label class="form-check-label" for="checkboxLoginRemember"> Remember me </label>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                        <div class="col">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form>
            </div>
          </div>
        </div>
    </div>

    {{-- scripts --}}
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script> --}}
    <script class="reloadable" type="text/javascript" src="{{ asset('plugins/MDB5-STANDARD-UI-KIT-Free-6.4.2/js/mdb.min.js') }}"></script>
    {{-- <script src="{{ asset('bootstrap-5.2.3/js/bootstrap.bundle.min.js') }}"></script> --}}
    @include('layouts.scripts')
    @yield('scripts')
</body>
</html>