<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/vyepti.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/material-icons-boilerplate.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Roboto+Mono:400,500|Material+Icons"
        rel="stylesheet">

    <!-- <link href="{{ asset('calendar/css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('calendar/css/fullcalendar.print.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('calendar/css/main.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</head>

<body class="d-flex flex-column h-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 px-0">
                @guest
                @else
                    <nav class="navbar navbar-expand-sm navbar-light bg-light px-8" aria-label="Tenth navbar example">
                        <div class="container-fluid px-0">
                            <a class="navbar-brand me-1" href="/"><img
                                    src="{{ asset('images/poweron_logo_only.svg') }}" alt="" width="52"></a>
                            <a class="navbar-brand me-1 pe-2" href="/"><img
                                    src="{{ asset('images/vyepti_icon.png') }}" alt="" width="120"></a>
                            <span class="navbar-text d-none d-md-block mx-1 w-100">
                                <p class="fc-vyepti-teal my-0">
                                    <i class="fa fa-quote-left fc-vyepti-teal fs-6 pe-0"></i>
                                    <span class="fs-5 fst-italic">Help your patients power through their migraines with our
                                        Power On treatment plan.</span>
                                    <i class="fa fa-quote-right fc-vyepti-teal fs-6 ps-0"></i>
                                </p>
                            </span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <!-- <span class="navbar-toggler-icon"></span> -->
                                <i class="material-icons dark-blue">more_vert</i>
                            </button>

                            <div class="collapse navbar-collapse justify-content-end mx-2" id="navbarsExample08">
                                <div class="text-center col-3 mx-auto d-none d-sm-block">
                                    <div class="fc-vyepti-teal btn-vyepti-teal-20 m-auto"
                                        style="width:40px;height:40px; border-radius:50%; padding:5px;">
                                        <p id="role_icon" class="fw-bold fs-5">
                                            @if (Auth::user()->role_id == 1)
                                                DR
                                            @elseif(Auth::user()->role_id == 2)
                                                NR
                                            @elseif(Auth::user()->role_id == 3)
                                                LB
                                            @elseif(Auth::user()->role_id == 4)
                                                SA
                                            @elseif(Auth::user()->role_id == 5)
                                                SP
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <ul class="navbar-nav">

                                    <li class="nav-item d-block d-sm-none">
                                        <a class="dropdown-item" href="{{ route('settings') }}">
                                            <div class="d-flex flex-wrap fc-vyepti-teal">
                                                <i class="material-icons pt-1">settings</i>
                                                <span class="fs-6 ms-1 mt-1">Settings</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item d-block d-sm-none">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <div class="d-flex flex-wrap fc-vyepti-teal">
                                                <i class="material-icons pt-1">logout</i>
                                                <span class="fs-6 ms-1 mt-1">Log Out</span>
                                            </div>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                    </li>
                                    <li class="nav-item dropdown d-none d-sm-block">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle mx-2" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdown08">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('settings') }}">
                                                    <div class="d-flex flex-wrap fc-vyepti-teal">
                                                        <i class="material-icons pt-1">settings</i>
                                                        <span class="fs-6 ms-1 mt-1">Settings</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                    <div class="d-flex flex-wrap fc-vyepti-teal">
                                                        <i class="material-icons pt-1">logout</i>
                                                        <span class="fs-6 ms-1 mt-1">Log Out</span>
                                                    </div>
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                @endguest

                <div class="row">
                    <div class="col-md-12">
                        @guest
                        @else
                            <button
                                class="btn btn-outline-light btn-sm shadow-sm rounded text-dark position-absolute fc-vyepti-teal btn-vyepti-steel-20"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                                aria-controls="offcanvasExample" style="z-index:999;">
                                <i class="fa fa-bars fa-2x"></i><br />
                                <span class="text-uppercase">MENU</span>
                            </button>

                            <div class="offcanvas offcanvas-start shadow" style="width: 250px !important; z-index:9999;"
                                data-bs-scroll="true" tabindex="-1" id="offcanvasExample"
                                aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header">
                                    <nav id="sidebar" class="active shadow ">
                                        <div class="pt-4">
                                            <div>
                                                <ul class="list-unstyled components pt-1 pl-4 mb-5 sidelink">
                                                    <li class="pl-4 ">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <a href="{{ URL::route('home') }}"
                                                                    class="font-weight-fh nav_link">
                                                                    Home
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                                                        <li class="pl-4 ">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <a href="{{ URL::route('RegisterPSP') }}"
                                                                        class="font-weight-fh nav_link">
                                                                        Power-On Treatment
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                                                        <li class="pl-4 ">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <a href="{{ URL::route('CreateAppointment') }}"
                                                                        class="font-weight-fh nav_link">
                                                                        Infusion Appointment
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    <li class="pl-4 ">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <a href="{{ URL::route('calendarview') }}"
                                                                    class="font-weight-fh nav_link">
                                                                    Calendar Overview
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                                        <li class="pl-4 ">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <a href="{{ URL::route('patientSummary') }}"
                                                                        class="font-weight-fh nav_link">
                                                                        Patient List
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                                                        <li class="pl-4 ">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <a href="{{ URL::route('Manage_patients') }}"
                                                                        class="font-weight-fh nav_link">
                                                                        Manage Patients
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if (Auth::user()->role_id == 4)
                                                        <li class="pl-4 ">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <a href="{{ URL::route('Manage_users') }}"
                                                                        class="font-weight-fh nav_link">
                                                                        Manage Users
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                    <!-- <li class="pl-4 ">
                                                                <div class="row">
                                                                    <div class="col-9">
                                                                        <a href="{{ route('learnmore') }}" class="font-weight-fh nav_link">
                                                                            About Vyepti
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li> -->

                                                    <!-- <li class="pl-4 ">
                                                                <div class="row">
                                                                    <div class="col-9">
                                                                        <a href="/roles" class="font-weight-fh" >
                                                                            Roles
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="pl-4 ">
                                                                <div class="row">

                                                                    <div class="col-9">
                                                                        <a href="/clinics" class="font-weight-fh" >
                                                                            Clinics
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="pl-4 ">
                                                                <div class="row">
                                                                    <div class="col-9">
                                                                        <a href="/treatments" class="font-weight-fh" >
                                                                            Treatments
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul> -->


                                                    <!-- <div class="sidebar-footer">
                                                            <ul class="list-unstyled components pt-1 sidelink">
                                                                <li class="pl-4 logout-class hr-class-top">
                                                                    <div class="row">
                                                                        <div class="col-1" style="margin:auto">
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <a class="font-weight-fh" href="#">Account Settings</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>

                                    <button
                                        class="btn btn-light bg-white btn-sm position-absolute fc-vyepti-teal btn-vyepti-steel-20"
                                        style="right: -55px !important; top: 100px !important;" type="button"
                                        data-bs-dismiss="offcanvas">
                                        <i class="fa fa-times fa-2x"></i><br />
                                        <span class="text-uppercase">MENU</span>
                                    </button>
                                </div>
                                <div class="offcanvas-body">
                                </div>
                            </div>
                        @endguest
                        <div class="">
                            @yield('content')

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    @yield('page-js-script')
    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="d-flex flex-column justify-content-center">
                <div>
                    <img class="rounded mx-auto d-block w-15" src="{{ asset('images/lundbeck_icon.svg') }}">
                </div>
                <div class="fc-vyepti-soft-black text-muted text-center">
                    @if (auth()->user())
                        <small>101 Thomson Rd, Singapore 307591</small>
                    @endif
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
