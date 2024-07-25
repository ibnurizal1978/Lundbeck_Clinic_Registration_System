@extends('layouts.app')
@section('content')

    <style>
        .nav-link.active {
            background-color: white !important;
            color: black !important;
            border-radius: 0px !important;
        }

        .nav-link {
            background-color: #EFF6F9 !important;
            color: #41748D !important;
            border-radius: 0px !important;
        }

        #navbarDropdown {
            background-color: white !important;
        }

        * {
            scrollbar-width: none;
        }

        .card-title {
            font-weight: 600;
        }

        .selected_date_text {
            font-weight: 500 !important;
        }
    </style>

    <div class="container-fluid px-8">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::route('home') }}"
                            class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Calendar Overview</li>
                </ol>
            </nav>
        </div>
        <div class="row border-bottom">
            <h4 class="fc-vyepti-teal">{{ date('l') }}, <small>{{ date('d F Y') }}</small></h4>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success btn-vyepti-steel-50 mt-3">
                {{ $message }}
            </div>
        @endif
        <div class="row justify-content-end mt-4">
            <div class="col-xs-12 col-md-9 d-none d-sm-none d-md-block">
                <div class="row justify-content-between mb-3">
                    <div class="col-md-6 col-xl-4 align-bottom my-auto ">
                        <div class="input-group input-group-sm mb-0">
                            <input type="text" class="form-control me-1 rounded search_patient"
                                placeholder="Search for Patient Appointments">
                            <button class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20" id="btn_search" type="button"
                                id="button-addon2">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5 col-xl-3">
                        <div class="d-grid gap-2">
                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                                <a href="{{ URL::route('CreateAppointment') }}"
                                    class="btn btn-sm btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                    <i class="material-icons pe-1">add_circle_outline</i>
                                    <small class="text-uppercase">Add Appointment</small>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card p-4 radius-class mb-3" style="padding:10px !important;">
                            <div class="d-flex justify-content-between bd-highlight">
                                <div class="d-inline-flex p-2 bd-highlight">
                                    <ul class="list-inline text-start my-0 pe-1">
                                        <li class="list-inline-item fw-bold" style="color: #484848!important;">Showing:</li>
                                        <li class="list-inline-item fst-italic fc-vyepti-teal search">All Appointments</li>
                                    </ul>
                                </div>
                                <div class="d-inline-flex p-2 bd-highlight bg-light bg-gradient px-0 py-0 my-auto">
                                    <ul class="list-inline text-end my-0 px-2 py-1 border rounded">
                                        <li class="list-inline-item fw-bold" style="color: #484848!important;">Legend: </li>
                                        <li class="list-inline-item"><i class="fa fa-circle apt-pending"
                                                aria-hidden="true"></i> Pending</li>
                                        <li class="list-inline-item"><i class="fa fa-circle apt-accepted"
                                                aria-hidden="true"></i> Accepted</li>
                                        <li class="list-inline-item"><i class="fa fa-circle apt-completed"
                                                aria-hidden="true"></i> Completed</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="calendar" style="height:650px!important;"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-none d-sm-none d-md-block">
                <div class="card rounded" style="">
                    <div class="card-header bg-white">
                        <input type="hidden" id="" class="selected_date" value='{{ date('Y-m-d') }}'>
                        <input type="hidden" id="search_patient_val" value=''>
                        <div class="d-flex justify-content-center align-items-center my-3">
                            <button class="btn btn-light fc-vyepti-teal btn-circle btn_prev" type="button" id="">
                                <i class="fa fa-chevron-left"></i><br />
                            </button>
                            <span id=""
                                class="selected_date_text mx-4 fc-vyepti-teal fs-5 fw-bold text-center">{{ date('d F Y') }}</span>
                            <button class="btn btn-light fc-vyepti-teal btn-circle btn_next" type="button" id="">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <ul id="" class="selected_date_events list-group list-group-flush">
                        @if (count($todays) > 0)
                            @foreach ($todays as $today)
                                <li class="list-group-item px-2">
                                    <h5 class="card-title">
                                        <i class="fa fa-circless {{ $today->session_status == '0' ? 'apt-pending' : ($today->session_status == '1' ? 'apt-accepted' : 'apt-completed') }} "
                                            aria-hidden="true"></i>
                                        {{ date('H:i', strtotime(str_replace('-', '/', $today->date) . ' ' . $today->time_start)) . ' - ' . date('H:i', strtotime(str_replace('-', '/', $today->date) . ' ' . $today->time_end)) }}
                                    </h5>
                                    <p class="card-text" id="a">
                                        @if (auth()->user()->role_id == 1)
                                            Patient Name: {{ $today->name }}
                                            @if (isset($today->patient_code) && $today->patient_code)
                                                <br />
                                                Patient Code: {{ $today->patient_code }}
                                            @endif
                                        @else
                                            Clinic: {{ $today->clinic_name }} <br />
                                            Medical Centre: {{ $today->medical_centre . ', ' . $today->unit }}
                                        @endif
                                        <br />
                                        <!-- added by Rizal for slide 12, just comment this -->
                                        <!--Created On: {{ date('d F Y', strtotime($today->created_at)) }}-->
                                        <!-- end added by Rizal -->
                                    </p>
                                    <div class="d-grid gap-2">

                                        <!-- added by Rizal for slide 27 -->
                                        @if(auth()->user()->role_id == 2 && $today->session_status == 1)
                                            <button class="btn btn-vyepti-teal fc-vyepti-steel-20 btn-sm"
                                                data-bs-toggle="modal" data-clinic-id="{{ $today->clinic_id }}"
                                                data-patient-id="{{ $today->patient_id }}"
                                                data-patient-name="{{ $today->name }}"
                                                data-patient-code="{{ $today->patient_code }}"
                                                data-patient-nric="{{ $today->nric }}"
                                                data-session-created_at="{{ $today->created_at }}"
                                                data-session-id="{{ $today->session_id }}"
                                                data-answer1="{{ $today->answer1 }}"
                                                data-answer2="{{ $today->answer2 }}"
                                                data-answer3="{{ $today->answer3 }}"
                                                data-answer4a="{{ $today->answer4a }}"
                                                data-answer4b="{{ $today->answer4b }}"
                                                data-remarks="{{ $today->remarks }}"
                                                data-nurse_id="{{ $today->nurse_id }}"
                                                data-nurse_name="{{ $today->nurse_name }}"
                                                data-bs-target="#staticBackdrop">
                                                <small class="text-uppercase">Start Treatment</small>
                                            </button>
                                        @endif
                                        <!-- end added by Rizal -->
                                        
                                        @if (auth()->user()->role_id == 4 ||
                                                auth()->user()->role_id == 2 ||
                                                (auth()->user()->role_id == 1 && ($today->session_status == 1 || $today->session_status == 2)))
                                            @if ($today->session_status == '2')
                                                <button class="btn btn-vyepti-teal fc-vyepti-steel-20 btn-sm" disabled>
                                                    <small class="text-uppercase">
                                                        Treatment Completed
                                                    </small>
                                                </button>
                                            @else
                                                @if (date('m-d-Y') == $today->date)
                                                    @if(auth()->user()->role_id <> 2 && $today->session_status <> 1)
                                                        <button class="btn btn-vyepti-teal fc-vyepti-steel-20 btn-sm"
                                                            data-bs-toggle="modal" data-clinic-id="{{ $today->clinic_id }}"
                                                            data-patient-id="{{ $today->patient_id }}"
                                                            data-patient-name="{{ $today->name }}"
                                                            data-patient-code="{{ $today->patient_code }}"
                                                            data-patient-nric="{{ $today->nric }}"
                                                            data-session-created_at="{{ $today->created_at }}"
                                                            data-session-id="{{ $today->session_id }}"
                                                            data-answer1="{{ $today->answer1 }}"
                                                            data-answer2="{{ $today->answer2 }}"
                                                            data-answer3="{{ $today->answer3 }}"
                                                            data-answer4a="{{ $today->answer4a }}"
                                                            data-answer4b="{{ $today->answer4b }}"
                                                            data-remarks="{{ $today->remarks }}"
                                                            data-nurse_id="{{ $today->nurse_id }}"
                                                            data-nurse_name="{{ $today->nurse_name }}"
                                                            data-bs-target="#staticBackdrop">
                                                            <small class="text-uppercase">Start Treatment</small>
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif

                                        @if (auth()->user()->role_id == 4 || auth()->user()->role_id == 1)
                                            <div class="row mx-auto text-center w-100">
                                                @if ($today->session_status == '2')
                                                    <div class="col-6 mb-2 mx-auto ps-0 pe-1">
                                                        <button
                                                            class="btn btn-vyepti-teal-outline fc-vyepti-teal btn-sm w-100 d-flex justify-content-center align-items-center px-0 py-0 btn-list"
                                                            disabled>
                                                            <i class="material-icons pe-1">edit_calendar</i>
                                                            <small class="text-uppercase">Update</small>
                                                        </button>
                                                    </div>
                                                    <div class="col-6 mb-2 mx-auto ps-1 pe-0">
                                                        <button
                                                            class="btn btn-vyepti-red-outline fc-vyepti-red btn-sm w-100 btn-cancel d-flex justify-content-center align-items-center px-0 py-0 btn-list"
                                                            disabled>
                                                            <i class="material-icons pe-1">cancel</i>
                                                            <small class="text-uppercase">Cancel</small>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="col-6 mb-2 mx-auto ps-0 pe-1">
                                                        <button
                                                            class="btn btn-vyepti-teal-outline fc-vyepti-teal btn-sm w-100 d-flex justify-content-center align-items-center px-0 py-0 btn-list"
                                                            data-bs-target="#staticBackdrop2" data-bs-toggle="modal"
                                                            data-patient-name2="{{ $today->name }}"
                                                            data-date="{{ $today->date }}"
                                                            data-start-time="{{ $today->time_start }}"
                                                            data-end-time="{{ $today->time_end }}"
                                                            data-patient-nric2="{{ $today->nric }}"
                                                            data-session-id2="{{ $today->session_id }}"
                                                            data-session-created_at2="{{ $today->created_at }}">
                                                            <i class="material-icons pe-1">edit_calendar</i>
                                                            <small class="text-uppercase">Update</small>
                                                        </button>
                                                    </div>
                                                    <div class="col-6 mb-2 mx-auto ps-1 pe-0">
                                                        <button
                                                            class="btn btn-vyepti-red-outline fc-vyepti-red btn-sm w-100 btn-cancel d-flex justify-content-center align-items-center px-0 py-0 btn-list"
                                                            data-session-id="{{ $today->session_id }}">
                                                            <i class="material-icons pe-1">cancel</i>
                                                            <small class="text-uppercase">Cancel</small>
                                                        </button>
                                                    </div>
                                                @endif

                                            </div>
                                        @endif

                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class='list-group-item px-2'>
                                <p class='card-text text-center fc-vyepti-teal'>There are no appointments for this day</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div id="hdnDiv" class="d-grid gap-2 d-none">
                <button id="btnShowEvents" class="" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                    <small class="text-uppercase">Show List </small>
                </button>
            </div>
        </div>
    </div>
    <div class="container d-block d-sm-block d-md-none px-1">
        <div class="row mb-3">
            <div class="col-12">
                <div class="input-group input-group-sm mb-0">
                    <input type="text" class="form-control me-1 rounded search_patient_mob"
                        placeholder="Search for Patient Appointments">
                    <button class="btn btn-sm btn-light btn-vyepti-teal fc-vyepti-steel-20" id="btn_search2"
                        type="button" id="button-addon2">
                        <i class="fa fa-2x fa-search"></i>
                    </button>
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                        <button onclick="location.href = '/CreateAppointment';"
                            class="btn btn-sm btn-light btn-vyepti-teal fc-vyepti-steel-20" id="btn_search2"
                            type="button" id="button-addon2">
                            <i class="material-icons md-36 p-auto m-auto">add_circle_outline</i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card p-4 radius-class mb-3" style="padding:10px !important;">
                    <div class="row mb-3">
                        <div class="col-12">
                            <ul class="list-inline text-start my-0 pe-1">
                                <li class="list-inline-item fw-bold" style="color: #484848!important;">Showing:</li>
                                <li class="list-inline-item fst-italic fc-vyepti-teal search">All Appointments</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="list-inline text-center my-0 px-2 py-1 border rounded">
                                <li class="list-inline-item fw-bold" style="color: #484848!important;">Legend: </li>
                                <li class="list-inline-item"><i class="fa fa-circle apt-pending" aria-hidden="true"></i>
                                    Pending</li>
                                <li class="list-inline-item"><i class="fa fa-circle apt-accepted" aria-hidden="true"></i>
                                    Accepted</li>
                                <li class="list-inline-item"><i class="fa fa-circle apt-completed"
                                        aria-hidden="true"></i> Completed</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>


                    <div id="calendar2" style="height:650px!important;"> </div>
                </div>
            </div>
        </div>
    </div>

    <!-- list of appointments -->
    <div class="modal" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="9999"
        aria-labelledby="staticBackdropLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fc-vyepti-teal" id="staticBackdropLabel">Appointment List</h5>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn-close ms-2 my-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="" class="selected_date" value='{{ date('Y-m-d') }}'>
                    <input type="hidden" id="search_patient_val" value=''>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-light fc-vyepti-teal btn-circle btn_prev" type="button" id="">
                            <i class="fa fa-chevron-left"></i><br />
                        </button>
                        <span id=""
                            class="selected_date_text mx-4 fc-vyepti-teal fs-5 fw-bold text-center">{{ date('d F Y') }}</span>
                        <button class="btn btn-light fc-vyepti-teal btn-circle btn_next" type="button" id="">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                    <hr />
                    <ul id="" class="selected_date_events list-group list-group-flush"></ul>
                </div>
            </div>
        </div>
    </div>

    <!--update remarks form -->
    <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="9999"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable h-75">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fc-vyepti-teal" id="staticBackdropLabel">Start Treatment</h5>
                    <div class="d-flex justify-content-end">
                        <!-- <a class="fc-hyperlink-blue text-decoration-none my-auto" target="_blank" href="/learnmore"> Learn more about vyepti</a> -->
                        <button type="button" class="btn-close ms-2 my-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div id="modalBody" class="modal-body mx-0 p-1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 px-1">
                                <form method="POST" action="{{ route('update_remarks') }}" id="update_remarks_form">
                                    @csrf
                                    <ul class="nav nav-pills mb-4 mx-0 px-0 text-center" id="myTab" role="tablist">
                                        <li class="nav-item col-4 mx-0 px-0 " role="presentation">
                                            <button class="nav-link active w-100" id="tab1" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                aria-controls="pills-home" aria-selected="true" disabled><small>STEP 1:
                                                    VERIFY</small></button>
                                        </li>
                                        <li class="nav-item col-4 mx-0 px-0" role="presentation">
                                            <button class="nav-link w-100" id="tab2" data-bs-toggle="pill"
                                                data-bs-target="#pills-profile" type="button" role="tab"
                                                aria-controls="pills-profile" aria-selected="false" disabled><small>STEP
                                                    2:
                                                    QUESTIONS</small></button>
                                        </li>
                                        <li class="nav-item col-4 mx-0 px-0 " role="presentation">
                                            <button class="nav-link w-100" id="tab3" data-bs-toggle="pill"
                                                data-bs-target="#pills-contact" type="button" role="tab"
                                                aria-controls="pills-contact" aria-selected="false" disabled><small>STEP
                                                    3:
                                                    COMPLETE</small></button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <!-- step 1 -->
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <input type="hidden" value="0" name="patient_id">
                                            <input type="hidden" value="0" name="session_id">
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">PERSONAL INFORMATION</h5>
                                                <div class="form-check col-12 px-1">
                                                    <label for="name" class="col-12 col-form-label fw-bold ">Full Name
                                                    </label>
                                                    <input type="text" id="name" class="col-12 form-control"
                                                        value="0" name="name" readonly>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <div class="form-check col-6 ps-1 pe-2">
                                                    <label id="label_code" name="label_code" for="code"
                                                        class="col-12 col-form-label fw-bold">Patient's Code </label>
                                                    <input type="text" id="code" class="col-12 form-control"
                                                        name="code" readonly>
                                                </div>
                                                <div class="form-check col-6 ps-2 pe-1">
                                                    <label for="nric" class="col-12 col-form-label fw-bold">NRIC
                                                    </label>
                                                    <input type="text" id="nric" class="col-12 form-control"
                                                        name="nric" readonly>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <div class="form-check col-12 px-1">
                                                    <label id="label_created_at" name="label_created_at" for="created_at"
                                                        class="col-12 col-form-label fw-bold">Created On </label>
                                                    <input type="text" id="created_at" class="col-12 form-control"
                                                        name="created_at" readonly>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row mx-0 mt- px-0 text-center">
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100"
                                                        data-bs-dismiss="modal">CANCEL</button>
                                                </div>
                                                <!-- added by Rizal, slide 30 -->
                                                <!--<div class="col-sm-6 mb-3 mx-auto">
                                                <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100"
                                                        onclick="step2()">SKIP</button>
                                                </div>-->
                                                <!-- end added by Rizal, slide 30 -->
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="step2()">NEXT</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- step 2 -->
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                            aria-labelledby="pills-profile-tab">
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">QUESTIONNAIRE</h5>
                                                <div class="form-check col-12 px-1">
                                                    <p>
                                                        <label for="answer1"
                                                            class="col-12 col-form-label fw-bold">Question 1/4</label>
                                                        <span class="">In the last month, how many migraine days did
                                                            you experience in a week on average?</span>
                                                        <select class="form-select" id="answer1" name="answer1">
                                                            <option value="">Please Select Answer</option>
                                                            <option value="Rarely - Once a week or less">Rarely - Once a
                                                                week or less</option>
                                                            <option value="Occasionally - 2 times a week ">Occasionally - 2
                                                                times a week </option>
                                                            <option value="Frequently - 3 times a week ">Frequently - 3
                                                                times a week </option>
                                                            <option value="Very Frequently - 4 or more times a week">Very
                                                                Frequently - 4 or more times a week</option>
                                                        </select>
                                                    </p>
                                                    <hr />

                                                    <p>
                                                        <label for="answer2"
                                                            class="col-12 col-form-label fw-bold">Question 2/4</label>
                                                        <span class="">In the last month, how many days did your
                                                            migraine affect your daily activities in a week on
                                                            average?</span>
                                                        <select class="form-select" id="answer2" name="answer2">
                                                            <option value="">Please Select Answer</option>
                                                            <option value="Rarely - Once a week or less">Rarely - Once a
                                                                week or less</option>
                                                            <option value="Occasionally - 2 times a week ">Occasionally - 2
                                                                times a week </option>
                                                            <option value="Frequently - 3 times a week ">Frequently - 3
                                                                times a week </option>
                                                            <option value="Very Frequently - 4 or more times a week">Very
                                                                Frequently - 4 or more times a week</option>
                                                        </select>
                                                    </p>
                                                    <hr />

                                                    <p>
                                                        <label for="answer3"
                                                            class="col-12 col-form-label fw-bold">Question 3/4</label>
                                                        <span class="">In the last month, how many days did you take
                                                            your acute medication to relive your headache in a week on
                                                            average?</span>
                                                        <select class="form-select" id="answer3" name="answer3">
                                                            <option value="">Please Select Answer</option>
                                                            <option value="Rarely - Once a week or less">Rarely - Once a
                                                                week or less</option>
                                                            <option value="Occasionally - 2 times a week ">Occasionally - 2
                                                                times a week </option>
                                                            <option value="Frequently - 3 times a week ">Frequently - 3
                                                                times a week </option>
                                                            <option value="Very Frequently - 4 or more times a week">Very
                                                                Frequently - 4 or more times a week</option>
                                                        </select>
                                                    </p>
                                                    <hr />

                                                    <p class="mb-0">
                                                        <label for="answer4a"
                                                            class="col-12 col-form-label fw-bold">Question 4/4</label>
                                                        <span class="">(a) What is your most bothersome
                                                            symptom?</span>
                                                    <div class="list-group mb-3">
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Photophobia">
                                                            Photophobia
                                                        </label>
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Phonophobia">
                                                            Phonophobia
                                                        </label>
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Smell">
                                                            Smell
                                                        </label>
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Nausea">
                                                            Nausea
                                                        </label>
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Dizziness">
                                                            Dizziness
                                                        </label>
                                                        <label class="list-group-item border-0 pb-0 symptom">
                                                            <input class="form-check-input ms-0 me-2" name="answer4a[]"
                                                                type="checkbox" value="Others">
                                                            Others
                                                        </label>
                                                    </div>
                                                    <span class="">(b) How often does this occur in a week on
                                                        average?</span>
                                                    <select class="form-select mt-1" id="answer4b" name="answer4b">
                                                        <option value="">Please Select Answer</option>
                                                        <option value="Rarely - Once a week or less">Rarely - Once a week
                                                            or less</option>
                                                        <option value="Occasionally - 2 times a week ">Occasionally - 2
                                                            times a week </option>
                                                        <option value="Frequently - 3 times a week ">Frequently - 3 times a
                                                            week </option>
                                                        <option value="Very Frequently - 4 or more times a week">Very
                                                            Frequently - 4 or more times a week</option>
                                                    </select>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mx-0 mt-4 px-0 text-center">
                                                <div class="col-sm-4 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal-outline fc-vyepti-teal-80 w-100"
                                                        onclick="step1()">PREVIOUS</button>
                                                </div>
                                                <!-- added by Rizal, slide 30 -->
                                                <div class="col-sm-4 mb-3 mx-auto">
                                                <a href="#ayam" type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal-outline fc-vyepti-teal-80 w-100"
                                                        onclick="step3(1).ScrolltoTop()">SKIP</a>
                                                </div>
                                                <!-- end added by Rizal, slide 30 -->
                                                <div class="col-sm-4 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="step3()">NEXT</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- step 3 -->
                                        <div id="ayam2"></div>
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                            aria-labelledby="pills-contact-tab">
                                            <div id="ayam"></div>
                                            <div class="row mx-0 pt-0 mb-2 pb-2">
                                                <div class="form-check col-12 px-0">
                                                    <div class="card">
                                                        <div class="card-body btn-vyepti-teal-20">
                                                            <h5 class="px-0">HAS THE TREATMENT BEEN COMPLETED?</h5>
                                                            <div class="d-flex">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_complete" id="is_complete_no"
                                                                        value="1" checked>
                                                                    <label class="form-check-label fs-5"
                                                                        for="is_complete_no">No</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_complete" id="is_complete_yes"
                                                                        value="2">
                                                                    <label class="form-check-label fs-5"
                                                                        for="is_complete_yes">Yes</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mx-0 pt-0 mb-2 pb-2">
                                                <h5 class="px-0">NOTES</h5>
                                                <div class="form-check col-12 px-0">
                                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="You can add notes here..."
                                                        rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="row my-3 mx-0 px-0">
                                                <h5 class="px-0">Nurse Identity</h5>
                                                <div class="row mx-0 px-0">
                                                    <div class="form-check col-6 ps-1 pe-2">
                                                        <label for="nurse_name"
                                                            class="col-12 col-form-label fw-bold">Nurse Name <span
                                                                class="text-danger">*</span> </label>
                                                        <input type="text" id="nurse_name" class="col-12 form-control"
                                                            name="nurse_name" required>
                                                    </div>
                                                    <div class="form-check col-6 ps-2 pe-1">
                                                        <label for="nurse_id" class="col-12 col-form-label fw-bold">Nurse
                                                            ID <span class="text-danger">*</span> </label>
                                                        <input type="text" id="nurse_id" class="col-12 form-control"
                                                            name="nurse_id" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">DISCLAIMER</h5>
                                                <div class="form-check col-12">
                                                    <input class="form-check-input ps-1" type="checkbox" value="1"
                                                        id="privacy-policy1" required>
                                                    <small class="form-check-label" for="privacy-policy1">
                                                        By making this submission, I warrant and represent that I have the
                                                        necessary consent of the patient to provide their personal data and
                                                        other clinical information to Lundbeck.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mx-0 mt-4 px-0 text-center">
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal-outline fc-vyepti-teal-80 w-100"
                                                        onclick="step2()">PREVIOUS</button>
                                                </div>
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="submitButton()">SUBMIT</button>
                                                    <input id="submit-hidden" type="submit" style="display: none" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--update appointment form -->
    <div class="modal" id="staticBackdrop2" data-bs-keyboard="false" tabindex="9999"
        aria-labelledby="staticBackdropLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fc-vyepti-teal" id="staticBackdropLabel2">Update Appointment</h5>
                    <div class="d-flex justify-content-end">
                        <!-- <a class="fc-hyperlink-blue text-decoration-none my-auto" target="_blank" href="/learnmore"> Learn more about vyepti</a> -->
                        <button type="button" class="btn-close ms-2 my-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body mx-0 p-1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 px-1">
                                <form method="POST" action="{{ route('update_session') }}"
                                    id="update_appointment_form">
                                    @csrf
                                    <ul class="nav nav-pills mb-4 mx-0 px-0 row col-12 text-center" id="myTab2"
                                        role="tablist">
                                        <li class="nav-item col-4 mx-0 px-0 " role="presentation">
                                            <button class="nav-link active w-100" id="update_appointment_tab11"
                                                data-bs-toggle="pill" data-bs-target="#pills-appointment_tab11"
                                                type="button" role="tab" aria-controls="pills-appointment_tab1"
                                                aria-selected="true"><small>STEP 1: VERIFY</small></button>
                                        </li>
                                        <li class="nav-item col-4 mx-0 px-0" role="presentation">
                                            <button class="nav-link w-100" id="update_appointment_tab22"
                                                data-bs-toggle="pill" data-bs-target="#pills-appointment_tab22"
                                                type="button" role="tab" aria-controls="pills-appointment_tab2"
                                                aria-selected="false"><small>STEP 2: UPDATE</small></button>
                                        </li>
                                        <li class="nav-item col-4 mx-0 px-0 " role="presentation">
                                            <button class="nav-link w-100" id="update_appointment_tab33"
                                                data-bs-toggle="pill" data-bs-target="#pills-appointment_tab33"
                                                type="button" role="tab" aria-controls="pills-appointment_tab3"
                                                aria-selected="false"><small>STEP 3: COMPLETE</small></button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent2">
                                        <!-- step 1 -->
                                        <div class="tab-pane fade show active" id="pills-appointment_tab11"
                                            role="tabpanel" aria-labelledby="pills-appointment_tab11">
                                            <input type="hidden" value="0" name="patient_id2">
                                            <input type="hidden" value="0" name="session_id2">
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">PERSONAL INFORMATION</h5>
                                                <div class="form-check col-12 px-1">
                                                    <label for="name" class="col-12 col-form-label fw-bold">Full Name
                                                    </label>
                                                    <input type="text" id="name2" class="col-12 form-control"
                                                        value="1" name="name2" readonly>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <div class="form-check col-6 ps-1 pe-2">
                                                    <label id="label_code2" name="label_code2" for="code"
                                                        class="col-12 col-form-label fw-bold">Patient's Code </label>
                                                    <input type="text" id="code2" class="col-12 form-control"
                                                        name="code2" readonly>
                                                </div>
                                                <div class="form-check col-6 ps-2 pe-1">
                                                    <label for="nric"
                                                        class="col-12 col-form-label fw-bold">NRIC</label>
                                                    <input type="text" id="nric2" class="col-12 form-control"
                                                        name="nric2" readonly>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <div class="form-check col-12 px-1">
                                                    <label id="label_created_at2" name="label_created_at2"
                                                        for="created_at2" class="col-12 col-form-label fw-bold">Created On
                                                    </label>
                                                    <input type="text" id="created_at2" class="col-12 form-control"
                                                        name="created_at2" readonly>
                                                </div>
                                            </div>
                                            <div class="row mx-0 mt-4 px-0 text-center">
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100"
                                                        data-bs-dismiss="modal">CANCEL</button>
                                                </div>
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="step22()">NEXT</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- step 2 -->
                                        <div class="tab-pane fade" id="pills-appointment_tab22" role="tabpanel"
                                            aria-labelledby="pills-appointment_tab22">
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">SCHEDULE</h5>
                                                <div class="form-check col-12 px-1">
                                                    <label for="date_session" class="col-12 col-form-label fw-bold">Date
                                                        <span class="text-danger">*</span></label>
                                                    <!-- <input type="date" id="date_session" name="date" class="col-12 form-control" required> -->
                                                    <div class="d-flex">
                                                        <!-- added by Rizal for slide 36 -->
                                                        <input class="form-control datepicker me-1" id="date_session"
                                                            name="date" placeholder="DD-MM-YYYY" required @if(auth()->user()->role_id == 3) disabled @endif>
                                                        <!--end added by Rizal -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mx-0 px-0">
                                                <div class="form-check col-12 px-1">
                                                    <label for="time"
                                                        class="col-12 col-form-label fw-bold">Time</label>
                                                    <select class="w-100 form-select" name="time" id="weekdays_time"
                                                        style="display: none">
                                                        <option value="">Please Select Time</option>
                                                        @foreach ($weekdays_times as $weekdays_time)
                                                            <option value="{{ $weekdays_time->times_id }}">
                                                                {{ $weekdays_time->times }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select class="w-100 form-select" name="time" id="weekends_time"
                                                        style="display: none">
                                                        <option value="">Please Select Time</option>
                                                        @foreach ($weekends_times as $weekends_time)
                                                            <option value="{{ $weekends_time->times_id }}">
                                                                {{ $weekends_time->times }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mx-0 mt-4 px-0 text-center">
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal-outline fc-vyepti-teal-80 w-100"
                                                        onclick="step11()">PREVIOUS</button>
                                                </div>
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="step33()">NEXT</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- step 3 -->
                                        <div class="tab-pane fade" id="pills-appointment_tab33" role="tabpanel"
                                            aria-labelledby="pills-appointment_tab33">
                                            <div class="row mx-0 px-0">
                                                <h5 class="px-0">DISCLAIMER</h5>
                                                <div class="form-check col-12">
                                                    <input class="form-check-input ps-1" type="checkbox" value="1"
                                                        id="privacy-policy2" required>
                                                    <small class="form-check-label" for="privacy-policy2">
                                                        By making this submission, I warrant and represent that I have the
                                                        necessary consent of the patient to provide their personal data and
                                                        other clinical information to Lundbeck.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mx-0 mt-4 px-0 text-center">
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal-outline fc-vyepti-teal-80 w-100"
                                                        onclick="step22()">PREVIOUS</button>
                                                </div>
                                                <div class="col-sm-6 mb-3 mx-auto">
                                                    <button type="button"
                                                        class="btn btn-sm rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                        onclick="submitButton2()">SUBMIT</button>
                                                    <input id="submit-hidden2" type="submit" style="display: none" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tooltip for calendar -->
    <!-- <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
                                                    <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script> -->
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/tooltip.min.js') }}" defer></script>
    <script src="{{ asset('calendar/js/main.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            dateFormat: "dd-mm-yy",
            showOn: "button",
            //added by Rizal for slide 36, add condition if(auth()->user blabla 
            buttonText: <?php if(auth()->user()->role_id == 3) { echo ""; }else{ ?>"<i class='fa fa-calendar fa-lg'></i>"<?php } ?>,
            minDate: 0, //disable past dates
            beforeShowDay: function(date) { //disable sundays
                var day = date.getDay();
                return [(day != 0), ''];
            },
        }).next(".ui-datepicker-trigger").addClass("btn btn-vyepti-teal fc-vyepti-steel-20");

        $("#date_session").on("change", function() {
            var selected_date = $(this).val();
            var selected_date_parts = selected_date.split('-');

            // get the day of the week (0 - Sunday, 1 - Monday, ..)
            var day_of_the_week = moment(selected_date_parts[2] + '-' + selected_date_parts[0] + '-' +
                selected_date_parts[1], "YYYY-DD-MM").day();

            // day_of_the_week = new Date(selected_date);
            if (day_of_the_week != 6) { // weekday (Sunday is disabled)
                $("#weekdays_time").attr('name', 'time')
                $("#weekdays_time").show();
                $('#weekdays_time').prop('required', true);

                $("#weekends_time").attr('name', 'weekends_time')
                $("#weekends_time").hide();
                $('#weekends_time').prop('required', false);

                $('#weekdays_time option').removeAttr('disabled');
                $('#weekdays_time option').each(function() {
                    if (this.value !== '' && moment().format('DD-MM-YYYY') === selected_date) {
                        var times_selected = this.value.split('-');
                        var times_selected_1 = moment(times_selected[0].trim(), 'HH:mm');
                        var times_selected_2 = moment(times_selected[1].trim(), 'HH:mm');
                        var currenthour = moment();
                        if (moment.duration(times_selected_1.diff(currenthour)).asHours() < 2) {
                            $(this).attr("disabled", true);
                        }
                    }
                });
            } else { // saturday
                $("#weekdays_time").attr('name', 'weekdays_time')
                $("#weekdays_time").hide();
                $('#weekdays_time').prop('required', false);

                $("#weekends_time").attr('name', 'time')
                $("#weekends_time").show();
                $('#weekends_time').prop('required', true);

                $('#weekends_time option').removeAttr('disabled');
                $('#weekends_time option').each(function() {
                    if (this.value !== '' && moment().format('DD-MM-YYYY') === selected_date) {
                        var times_selected = this.value.split('-');
                        var times_selected_1 = moment(times_selected[0].trim(), 'HH:mm');
                        var times_selected_2 = moment(times_selected[1].trim(), 'HH:mm');
                        var currenthour = moment();
                        if (moment.duration(times_selected_1.diff(currenthour)).asHours() < 2) {
                            $(this).attr("disabled", true);
                        }
                    }
                });
            }
        });

        // functions
        function step1() {
            $('#tab1').tab('show');
        }

        function step2() {
            $('#tab2').tab('show').scrollTop(0);
        }

        function step3() {
            $('#tab3').tab('show');
            $('#modalBody').scrollTop(0);
        }

        function submitButton() {
            $("#update_remarks_form").find("#submit-hidden").click();
        }

        function step11() {
            $('#update_appointment_tab11').tab('show');
        }

        function step22() {
            $('#update_appointment_tab22').tab('show');
        }

        function step33() {
            $('#privacy-policy2').prop('required', false);
            if (!$("#update_appointment_form")[0].checkValidity()) {
                $("#update_appointment_form").find("#submit-hidden2").click();
            } else {
                $('#privacy-policy2').prop('required', true);
                $('#update_appointment_tab33').tab('show');
            }
        }

        function submitButton2() {
            if (!$("#update_appointment_form")[0].checkValidity()) {
                $("#update_appointment_form").find("#submit-hidden2").click();
            } else {
                $("#update_appointment_form").find("#submit-hidden2").click();
            }
        }
    </script>
@endsection

@section('page-js-script')
    <script>
        var SITEURL = "{{ url('/') }}";

        $(document).ready(function() {
            // events
            $(document).on("click", ".btn-cancel", function() {
                var session_id = $(this).data('session-id');

                if (confirm("Please click OK to confirm.")) {
                    cancelAppointment($(this));
                }
            });

            $(document).on("click", "#btn_search, #btn_search2", function() {
                searchPatient();
            });

            $(document).on("click", ".btn_prev", function() {
                var orig_date = moment($(".selected_date").val());
                var new_date = orig_date.subtract('1', 'days');

                $(".selected_date").val(moment(new_date).format('YYYY-MM-DD'));
                $(".selected_date_text").html(moment(new_date).format('MMM D, YYYY'));

                showEventList();
            });

            $(document).on("click", ".btn_next", function() {
                var orig_date = moment($(".selected_date").val());
                var new_date = orig_date.add('1', 'days');

                $(".selected_date").val(moment(new_date).format('YYYY-MM-DD'));
                $(".selected_date_text").html(moment(new_date).format('MMM D, YYYY'));

                showEventList();
            });

            //return the correct values from the modal // update  remark
            //fields
            $('#staticBackdrop').on('show.bs.modal', function(e) {
                var session_id = $(e.relatedTarget).data('session-id');
                var patient_id = $(e.relatedTarget).data('patient-id');
                var patient_name = $(e.relatedTarget).data('patient-name');
                var patient_code = $(e.relatedTarget).data('patient-code');
                var patient_nric = $(e.relatedTarget).data('patient-nric');
                var created_at = $(e.relatedTarget).data('session-created_at');

                var answer1 = $(e.relatedTarget).data('answer1');
                var answer2 = $(e.relatedTarget).data('answer2');
                var answer3 = $(e.relatedTarget).data('answer3');
                var answer4a = $(e.relatedTarget).data('answer4a');
                var answer4b = $(e.relatedTarget).data('answer4b');

                var remarks = $(e.relatedTarget).data('remarks');
                var nurse_id = $(e.relatedTarget).data('nurse_id');
                var nurse_name = $(e.relatedTarget).data('nurse_name');

                $(e.currentTarget).find('input[name="session_id"]').val(session_id);
                $(e.currentTarget).find('input[name="patient_id"]').val(patient_id);
                $(e.currentTarget).find('input[name="name"]').val(patient_name);
                $(e.currentTarget).find('input[name="code"]').val(patient_code);
                $(e.currentTarget).find('input[name="nric"]').val(patient_nric);
                $(e.currentTarget).find('input[name="created_at"]').val(moment(created_at).format(
                    'DD MMMM YYYY'));

                if (patient_code == undefined || patient_code == "") {
                    $(e.currentTarget).find('input[name="code"]').addClass("readonly");
                    $("#label_code").addClass("readonly");
                    patient_code = "NA";
                } else {
                    $(e.currentTarget).find('input[name="code"]').removeClass("readonly");
                    $("#label_code").removeClass("readonly");
                }

                $(e.currentTarget).find('input[name="code"]').val(patient_code);
                var arrAnswer4a = (answer4a != null) ? answer4a.split(",") : [];

                $(e.currentTarget).find('#answer1').val(answer1 == null ? '' : answer1);
                $(e.currentTarget).find('#answer2').val(answer2 == null ? '' : answer2);
                $(e.currentTarget).find('#answer3').val(answer3 == null ? '' : answer3);
                $(e.currentTarget).find('input[name="answer4a[]"]').val(arrAnswer4a);
                $(e.currentTarget).find('#answer4b').val(answer4b == null ? '' : answer4b);
                $(e.currentTarget).find('#remarks').val(remarks);
                $(e.currentTarget).find('#nurse_id').val(nurse_id);
                $(e.currentTarget).find('#nurse_name').val(nurse_name);
            });

            //return the correct values from the modal // update  session
            //fields
            $('#staticBackdrop2').on('show.bs.modal', function(e) {
                $("#staticBackdrop2").val(null).trigger("change");

                var session_id = $(e.relatedTarget).data('session-id2');
                var patient_id = $(e.relatedTarget).data('patient-id2');
                var patient_name = $(e.relatedTarget).data('patient-name2');
                var patient_code = $(e.relatedTarget).data('patient-code2');
                var patient_nric = $(e.relatedTarget).data('patient-nric2');
                var created_at = $(e.relatedTarget).data('session-created_at2');

                $(e.currentTarget).find('input[name="session_id2"]').val(session_id);
                $(e.currentTarget).find('input[name="patient_id2"]').val(patient_id);
                $(e.currentTarget).find('input[name="name2"]').val(patient_name);
                $(e.currentTarget).find('input[name="nric2"]').val(patient_nric);
                $(e.currentTarget).find('input[name="created_at2"]').val(moment(created_at).format(
                    'DD MMMM YYYY'));

                if (patient_code == undefined || patient_code == "") {
                    $(e.currentTarget).find('input[name="code2"]').addClass("readonly");
                    $("#label_code2").addClass("readonly");
                    patient_code = "NA";
                } else {
                    $(e.currentTarget).find('input[name="code2"]').removeClass("readonly");
                    $("#label_code2").removeClass("readonly");
                }

                $(e.currentTarget).find('input[name="code2"]').val(patient_code);
            });

            // $('input[name=is_complete]').change( function() {
            //     if(this.value == "1") {
            //         $("#remarks").hide();
            //     } else {
            //         $("#remarks").show();
            //     }
            // });

            $(".search_patient, .search_patient_mob").on('keyup', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    searchPatient();
                }
            });

            var calendar;
            var calendar2;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                height: 'auto',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: '',
                    center: 'prev title next',
                    right: ''
                },
                eventDidMount: function(arg) {
                    var search = $("#search_patient_val").val();
                    var event_title = arg.event.title;
                    var search_reg = new RegExp(search, 'gi');

                    if (!(event_title.match(search_reg) || search == "")) {
                        arg.el.style.display = "none";
                    }

                    // tooltip
                    var tooltip = new Tooltip(arg.el, {
                        title: arg.event.extendedProps.description,
                        placement: 'auto',
                        trigger: 'hover',
                        container: 'body'
                    });
                },
                events: function(info, successCallback, failureCallback) {
                    var middate = new Date((info.start.getTime() + info.end.getTime()) / 2);
                    var event_month = ("0" + (middate.getMonth() + 1)).slice(-2);
                    var event_year = middate.getFullYear();

                    $.ajax({
                        url: SITEURL + "/calendar-crud-ajax",
                        data: {
                            date: '',
                            month: event_month,
                            year: event_year,
                            type: 'retrieve'
                        },
                        type: "POST",
                        success: function(data) {
                            var events = [];
                            data.forEach((element) => {
                                var event_date = element.date.split("-");

                                var title =
                                    @if (auth()->user()->role_id == 1)
                                        element.name
                                    @else
                                        element
                                            .clinic_name
                                    @endif ;
                                var patientcode = (element.patient_code == null) ?
                                    '' : ' [' + element.patient_code + ']';
                                var description =
                                    @if (auth()->user()->role_id == 1)
                                        element.name +
                                            patientcode
                                    @else
                                        element.clinic_name + ' [' + element
                                            .medical_centre +
                                            ']'
                                    @endif ;

                                events.push({
                                    title: title,
                                    session_date: element.date,
                                    start: event_date[2] + '-' + event_date[
                                            0] + '-' + event_date[1] + ' ' +
                                        element.time_start,
                                    end: event_date[2] + '-' + event_date[
                                            0] + '-' + event_date[1] + ' ' +
                                        element.time_end,
                                    description: description,
                                    nric: element.nric,
                                    status: element.session_status,
                                    clinic: element.clinic_id,
                                    clinic_name: element.clinic_name,
                                    medical_centre: element.medical_centre,
                                    unit: element.unit,
                                    patient_name: element.name,
                                    patient_id: element.patient_id,
                                    patient_code: element.patient_code,
                                    appointment_id: element.appointment_id,
                                    session_id: element.session_id,
                                    answer1: element.answer1,
                                    answer2: element.answer2,
                                    answer3: element.answer3,
                                    answer4a: element.answer4a,
                                    answer4b: element.answer4b,
                                    remarks: element.remarks,
                                    nurse_id: element.nurse_id,
                                    nurse_name: element.nurse_name,
                                    created_at: element.created_at
                                });
                            });
                            successCallback(events);
                        },
                        error: function(request, status, error) {
                            failureCallback(error);
                        }
                    });

                },
                selectable: true,
                dateClick: function(info) {
                    $(".selected_date_events").empty();
                    $("#loading_spinner").removeClass("visually-hidden");

                    var selected_date = new Date(info.date);

                    $(".selected_date").val(moment(selected_date).format('YYYY-MM-DD'));
                    $(".selected_date_text").html(moment(selected_date).format('DD MMMM YYYY'));

                    showEventList();

                    $("#loading_spinner").addClass("visually-hidden");
                },
                eventClick: function(info) {
                    $(".selected_date").val(moment(info.event.startStr).format('YYYY-MM-DD'));
                    $(".selected_date_text").html(moment(info.event.startStr).format('DD MMMM YYYY'));

                    showEventList();

                    var role = "{{ Auth::user()->role_id }}";

                    if (info.event.extendedProps.status != "2") {
                        if (role == "2" && info.event.extendedProps.status == "1") {
                            $('#hdnDiv').html(
                                '<button id="btnUpdateRemarks" class="" data-bs-toggle="modal" ' +
                                '   data-clinic-id="' + info.event.extendedProps.clinic + '" ' +
                                '   data-patient-id="' + info.event.extendedProps.patient_id +
                                '" ' +
                                '   data-patient-name="' + info.event.extendedProps.patient_name +
                                '" ' +
                                '   data-patient-code="' + info.event.extendedProps.patient_code +
                                '" ' +
                                '   data-patient-nric="' + info.event.extendedProps.nric + '" ' +
                                '   data-session-created_at="' + info.event.extendedProps
                                .created_at + '" ' +
                                '   data-session-id="' + info.event.extendedProps.session_id +
                                '" ' +
                                '   data-answer1="' + info.event.extendedProps.answer1 + '" ' +
                                '   data-answer2="' + info.event.extendedProps.answer2 + '" ' +
                                '   data-answer3="' + info.event.extendedProps.answer3 + '" ' +
                                '   data-answer4a="' + info.event.extendedProps.answer4a + '" ' +
                                '   data-answer4b="' + info.event.extendedProps.answer4b + '" ' +
                                '   data-remarks="' + info.event.extendedProps.remarks + '" ' +
                                '   data-nurse_id="' + info.event.extendedProps.nurse_id + '" ' +
                                '   data-nurse_name="' + info.event.extendedProps.nurse_name +
                                '" ' +
                                '   data-bs-target="#staticBackdrop"> ' +
                                '   <small class="text-uppercase">Start Treatment</small> ' +
                                '</button>'
                            );

                            $("#btnUpdateRemarks").click();

                        } else if(role === '4' || role === '1' || role === '5') {
                            $('#hdnDiv').html(
                                '<button id="btnUpdateAppointment" class="" data-bs-toggle="modal" ' +
                                '   data-patient-id2="' + info.event.extendedProps.patient_id +
                                '" ' +
                                '   data-patient-name2="' + info.event.extendedProps.patient_name +
                                '" ' +
                                '   data-patient-code2="' + info.event.extendedProps.patient_code +
                                '" ' +
                                '   data-date="' + moment(info.event.startStr).format(
                                    'MM-DD-YYYY') + '" ' +
                                '   data-start-time="' + moment(info.event.startStr).format(
                                    'MM-DD-YYYY') + '" ' +
                                '   data-end-time="' + moment(info.event.endStr).format(
                                    'MM-DD-YYYY') + '" ' +
                                '   data-patient-nric2="' + info.event.extendedProps.nric + '" ' +
                                '   data-session-created_at2="' + info.event.extendedProps
                                .created_at + '" ' +
                                '   data-session-id2="' + info.event.extendedProps.session_id +
                                '" ' +
                                '   data-bs-target="#staticBackdrop2"> ' +
                                '   <small class="text-uppercase">Update Appointment </small> ' +
                                '</button>'
                            );

                            $("#btnUpdateAppointment").click();
                        }
                    }
                }
            });
            calendar.render();

            var calendarEl2 = document.getElementById('calendar2');
            calendar2 = new FullCalendar.Calendar(calendarEl2, {
                height: 'auto',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: '',
                    center: 'prev title next',
                    right: ''
                },
                eventDidMount: function(arg) {
                    var search = $("#search_patient_val").val();
                    var event_tile = arg.event.title;
                    var search_reg = new RegExp(search, 'gi');

                    if (!(event_tile.match(search_reg) || search == "")) {
                        arg.el.style.display = "none";
                    }
                },
                events: function(info, successCallback, failureCallback) {
                    var middate = new Date((info.start.getTime() + info.end.getTime()) / 2);
                    var event_month = ("0" + (middate.getMonth() + 1)).slice(-2);
                    var event_year = middate.getFullYear();

                    $.ajax({
                        url: SITEURL + "/calendar-crud-ajax",
                        data: {
                            date: '',
                            month: event_month,
                            year: event_year,
                            type: 'retrieve'
                        },
                        type: "POST",
                        success: function(data) {
                            var events = [];
                            data.forEach((element) => {
                                var event_date = element.date.split("-");

                                var title =
                                    @if (auth()->user()->role_id == 1)
                                        element.name
                                    @else
                                        element
                                            .clinic_name
                                    @endif ;
                                var patientcode = (element.patient_code == null) ?
                                    '' : ' [' + element.patient_code + ']';
                                var description =
                                    @if (auth()->user()->role_id == 1)
                                        element.name +
                                            patientcode
                                    @else
                                        element.clinic_name + ' [' + element
                                            .medical_centre +
                                            ']'
                                    @endif ;

                                events.push({
                                    title: title,
                                    session_date: element.date,
                                    start: event_date[2] + '-' + event_date[
                                            0] + '-' + event_date[1] + ' ' +
                                        element.time_start,
                                    end: event_date[2] + '-' + event_date[
                                            0] + '-' + event_date[1] + ' ' +
                                        element.time_end,
                                    description: description,
                                    nric: element.nric,
                                    status: element.session_status,
                                    clinic: element.clinic_id,
                                    clinic_name: element.clinic_name,
                                    medical_centre: element.medical_centre,
                                    unit: element.unit,
                                    patient_name: element.name,
                                    patient_id: element.patient_id,
                                    patient_code: element.patient_code,
                                    appointment_id: element.appointment_id,
                                    session_id: element.session_id,
                                    answer1: element.answer1,
                                    answer2: element.answer2,
                                    answer3: element.answer3,
                                    answer4a: element.answer4a,
                                    answer4b: element.answer4b,
                                    remarks: element.remarks,
                                    nurse_id: element.nurse_id,
                                    nurse_name: element.nurse_name,
                                    created_at: element.created_at
                                });
                            });
                            successCallback(events);
                        },
                        error: function(request, status, error) {
                            failureCallback(error);
                        }
                    });
                },
                selectable: true,
                dateClick: function(info) {
                    $(".selected_date_events").empty();
                    var selected_date = new Date(info.date);

                    $(".selected_date").val(moment(selected_date).format('YYYY-MM-DD'));
                    $(".selected_date_text").html(moment(selected_date).format('DD MMMM YYYY'));

                    showEventList();
                    $("#btnShowEvents").click();
                },
                eventClick: function(info) {
                    $(".selected_date").val(moment(info.event.startStr).format('YYYY-MM-DD'));
                    $(".selected_date_text").html(moment(info.event.startStr).format('DD MMMM YYYY'));

                    showEventList();
                    $("#btnShowEvents").click();
                }
            });
            calendar2.render();

            function showEventList() {
                var data = calendar.getEvents();

                if (data.length < 1) {
                    data = calendar2.getEvents();
                }

                var search = $("#search_patient_val").val();
                var search_reg = new RegExp(search, 'gi');
                var selected_date_formatted = $(".selected_date").val();

                var events_count = 0;

                // load events from the selected date
                if (data.length > 0) {
                    $(".selected_date_events").empty();
                    data.forEach((element) => {
                        var event_date = new Date(element.startStr);
                        if (selected_date_formatted == moment(event_date).format('YYYY-MM-DD') && (element
                                .title.match(search_reg) || search == "")) {
                            events_count++;

                            var event_start_date = new Date(element.startStr);
                            var event_end_date = new Date(element.endStr);

                            var status_dot;
                            switch (element.extendedProps.status) {
                                case 0:
                                    status_dot = "apt-pending";
                                    break;
                                case 1:
                                    status_dot = "apt-accepted";
                                    break;
                                case 2:
                                    status_dot = "apt-completed";
                                    break;
                            }
                            //udah tapi nggak ngaruh
                            var inside_html =
                                '   <li class="list-group-item px-2">' +
                                '       <h5 class="card-title">' +
                                '           <i class="fa fa-circleqq ' + status_dot +
                                '" aria-hidden="true"></i> ' + moment(event_start_date).format("HH:mm") +
                                ' - ' + moment(event_end_date).format("HH:mm") +
                                '       </h5>';

                            @if (auth()->user()->role_id == 1)
                                inside_html += '       <p class="card-text">Patient Name: ' + element.title;

                                if (element.extendedProps.patient_code) {
                                    inside_html += '<br/>' + 'Patient Code: ' + element.extendedProps
                                        .patient_code;
                                }
                            @else
                                inside_html +=
                                    '       <p class="card-text">Clinic: ' + element.extendedProps
                                    .clinic_name +
                                    '           <br/>Medical Centre: ' + element.extendedProps
                                    .medical_centre + ", " + element.extendedProps.unit;
                            @endif

                            // if(element.extendedProps.status == "2") {
                            //     inside_html +=
                            //     '           <br/>Status: Treatment Completed';
                            // }

                            /*== commented by Rizal, based on slide 12 PPT 
                            inside_html += '<br/>' + 'Created Onq: ' + moment(element.extendedProps
                                .created_at).format(
                                "DD MMMM YYYY");
                                ==*/

                            inside_html += '</p>' +
                                '       <div class="d-grid gap-2">';

                            var role = "{{ auth()->user()->role_id }}";

                            // update remarks
                            if (role == "4" || role == "2" || (role == "1" && (element.extendedProps
                                    .status == "1" || element.extendedProps.status == "2"))) {
                                if (element.extendedProps.status == "2") {
                                    inside_html +=
                                        '           <button class="btn btn-vyepti-teal fc-vyepti-steel-20 btn-sm" disabled>' +
                                        '               <small class="text-uppercase">Treatment Completed</small>' +
                                        '           </button>';
                                } else {
                                    //if (moment().format('MM-DD-YYYY') == element.extendedProps.session_date) {
                                            console.log(element.extendedProps.session_date);                         

                                            if (role == "2" && element.extendedProps.status == "1") {
                                                    inside_html +=
                                                    '           <button class="btn btn-vyepti-teal fc-vyepti-steel-20 btn-sm" ' +
                                                    '               data-bs-toggle="modal" ' +
                                                    '               data-clinic-id="' + element.extendedProps
                                                    .clinic + '" ' +
                                                    '               data-patient-id="' + element.extendedProps
                                                    .patient_id + '" ' +
                                                    '               data-patient-name="' + element.extendedProps
                                                    .patient_name + '" ' +
                                                    '               data-patient-code="' + element.extendedProps
                                                    .patient_code + '" ' +
                                                    '               data-patient-nric="' + element.extendedProps
                                                    .nric + '" ' +
                                                    '               data-session-created_at="' + element
                                                    .extendedProps
                                                    .created_at + '" ' +
                                                    '               data-session-id="' + element.extendedProps
                                                    .session_id + '" ' +
                                                    '               data-answer1="' + element.extendedProps
                                                    .answer1 + '" ' +
                                                    '               data-answer2="' + element.extendedProps
                                                    .answer2 + '" ' +
                                                    '               data-answer3="' + element.extendedProps
                                                    .answer3 + '" ' +
                                                    '               data-answer4a="' + element.extendedProps
                                                    .answer4a + '" ' +
                                                    '               data-answer4b="' + element.extendedProps
                                                    .answer4b + '" ' +
                                                    '               data-remarks="' + element.extendedProps
                                                    .remarks + '" ' +
                                                    '               data-nurse_id="' + element.extendedProps
                                                    .nurse_id + '" ' +
                                                    '               data-nurse_name="' + element.extendedProps
                                                    .nurse_name + '" ' +
                                                    '               data-bs-target="#staticBackdrop">' +
                                                    '               <small class="text-uppercase">.Start Treatment</small>' +
                                                    '           </button>';
                                                
                                            
                                            }else{
                                                inside_html += '';
                                            }

                                        
                                    //}
                                }
                            }

                            // update appointment
                            if (role == "4" || role == "1" || role == "5") {
                                if (element.extendedProps.status == "2") {
                                    inside_html +=
                                        '<div class="row mx-auto text-center w-100">' +
                                        // d-none d-sm-none d-md-block
                                        '    <div class="col-6 mb-2 mx-auto ps-0 pe-1">' +
                                        '       <button class="btn btn-vyepti-teal-outline fc-vyepti-teal btn-sm w-100 d-flex justify-content-center align-items-center px-0 py-0 btn-list" disabled>' +
                                        '           <i class="material-icons pe-1">edit_calendar</i>' +
                                        '           <small class="text-uppercase">Update</small>' +
                                        '       </button>' +
                                        '    </div>' +
                                        '    <div class="col-6 mb-2 mx-auto ps-1 pe-0">' +
                                        '       <button class="btn btn-vyepti-red-outline fc-vyepti-red btn-sm w-100 btn-cancel d-flex justify-content-center align-items-center px-0 py-0 btn-list" disabled>' +
                                        '           <i class="material-icons pe-1">cancel</i>' +
                                        '           <small class="text-uppercase">Cancel</small>' +
                                        '       </button>' +
                                        '    </div>' +
                                        '</div>';
                                } else {
                                    inside_html +=
                                        '<div class="row mx-auto text-center w-100">' +
                                        // d-none d-sm-none d-md-block
                                        '    <div class="col-6 mb-2 mx-auto ps-0 pe-1">' +
                                        '       <button class="btn btn-vyepti-teal-outline fc-vyepti-teal btn-sm w-100 d-flex justify-content-center align-items-center px-0 py-0 btn-list"' +
                                        '           data-bs-toggle="modal" ' +
                                        '           data-patient-id2="' + element.extendedProps.patient_id +
                                        '" ' +
                                        '           data-patient-name2="' + element.extendedProps
                                        .patient_name + '" ' +
                                        '           data-patient-code2="' + element.extendedProps
                                        .patient_code + '" ' +
                                        '           data-date="' + moment(event_date).format('MM-DD-YYYY') +
                                        '" ' +
                                        '           data-start-time="' + moment(event_start_date).format(
                                            'HH:mm:ss') + '" ' +
                                        '           data-end-time="' + moment(event_end_date).format(
                                            'HH:mm:ss') + '" ' +
                                        '           data-patient-nric2="' + element.extendedProps.nric +
                                        '" ' +
                                        '           data-session-created_at2="' + element.extendedProps
                                        .created_at + '" ' +
                                        '           data-session-id2="' + element.extendedProps.session_id +
                                        '" ' +
                                        '           data-bs-target="#staticBackdrop2">' +
                                        '           <i class="material-icons pe-1">edit_calendar</i>' +
                                        '           <small class="text-uppercase">Update</small>' +
                                        '       </button>' +
                                        '    </div>' +
                                        '    <div class="col-6 mb-2 mx-auto ps-1 pe-0">' +
                                        '       <button class="btn btn-vyepti-red-outline fc-vyepti-red btn-sm w-100 btn-cancel d-flex justify-content-center align-items-center px-0 py-0 btn-list"' +
                                        '           data-session-id="' + element.extendedProps.session_id +
                                        '">' +
                                        '           <i class="material-icons pe-1">cancel</i>' +
                                        '           <small class="text-uppercase">Cancel</small>' +
                                        '       </button>' +
                                        '    </div>' +
                                        '</div>';
                                }

                            }

                            inside_html +=
                                '       </div>' +
                                '   </li>';

                            $(".selected_date_events").append(inside_html);
                        }
                    });
                }

                if (events_count < 1) {
                    $(".selected_date_events").empty();

                    var inside_html = "<li class='list-group-item px-2'>" +
                        "<p class='card-text text-center fc-vyepti-teal'>There are no appointments for this day</p>" +
                        "</li>";

                    $(".selected_date_events").append(inside_html);
                }
            }

            function searchPatient() {
                var keyword = $(".search_patient").val() != '' ? $(".search_patient").val() : $(
                    ".search_patient_mob").val();

                $("#search_patient_val").val(keyword);

                if (keyword == '') {
                    keyword = "All Appointments";
                }

                $(".search").html(keyword);
                calendar.refetchEvents();
                calendar2.refetchEvents();
            }

            function cancelAppointment(elem) {
                var session_id = elem.data('session-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: SITEURL + "/cancel_appointment",
                    data: {
                        session_id: session_id
                    },
                    type: "POST",
                    success: function(data) {
                        if (data) {
                            var parent = elem.closest("li");
                            parent.remove();

                            calendar.refetchEvents();
                            calendar2.refetchEvents();
                        }
                    },
                    error: function(request, status, error) {
                        failureCallback(error);
                    }
                });
            }

        });
    </script>
@stop
