@extends('layouts.app')
@section('content')
    <div class="container-fluid px-8">
        <!-- <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </nav>
                </div> -->
        <div class="row justify-content-center align-items-stretch">
            <!-- success message -->
            @if (session()->has('message'))
                <div class="alert alert-success btn-vyepti-steel-50">
                    {{ session()->get('message') }}
                </div>
            @endif
            <!-- <h4 class="fc-vyepti-teal">Dashboard <small class="text-dark">{{ date('d F Y, l') }}</small></h4>  -->
        </div>

        <div class="row justify-content-center align-items-stretch">
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                <div class="col-12 col-md-8 col-lg-5 col-xl-4 col-xxl-3 px-2 py-2">
                    <div class="card card-bg border-0 bg-body rounded-3 h-100">
                        <div class="card-body px-3 py-4 d-flex justify-content-center">
                            <div class="d-flex justify-content-center flex-column align-items-stretch">
                                <div class="mx-auto d-block">
                                    <img height="80" src="{{asset('images/efficacious.svg')}}"/>
                                </div>
                                <div class="mx-auto d-block">
                                    <h4 class="fc-vyepti-teal text-center my-0">Vyepti Power-on Treatment Plan</h4>
                                </div>
                                <div class="h-100">
                                    <div class="row h-100">
                                        <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                            <p class="card-text text-justify fs-7 fw-normal my-2">A treatment plan for your
                                                patients to be started on the right treatment, stay on track, and to take
                                                control of their migraine as long as possible!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-100">
                                    <div class="row h-100">
                                        <div class="col-12 col-md-8 mx-auto align-self-end">
                                            <a href="{{ URL::route('RegisterPSP') }}"
                                                class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                <small class="text-uppercase">Enroll Now</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                <div class="col-12 col-md-8 col-lg-5 col-xl-4 col-xxl-3 px-2 py-2">
                    <div class="card card-bg border-0 bg-body rounded-3 h-100">
                        <div class="card-body px-3 py-4 d-flex justify-content-center">
                            <div class="d-flex justify-content-center flex-column align-items-stretch">
                                <div class="mx-auto d-block">
                                    <img height="80" src="{{asset('images/IVfusion.svg')}}"/>
                                </div>
                                <div class="mx-auto d-block">
                                    <h4 class="fc-vyepti-teal text-center my-0">Infusion Appointment</h4>
                                </div>
                                <div class="h-100">
                                    <div class="row h-100">
                                        <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                            <p class="card-text text-justify fs-7 fw-normal my-2">Book a 30 minutes hassle
                                                free
                                                infusion service with our professional nurse agency team at the preferred
                                                date
                                                and time of your patient.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-100">
                                    <div class="row h-100">
                                        <div class="col-12 col-md-8 mx-auto align-self-end">
                                            <a href="{{ URL::route('CreateAppointment') }}"
                                                class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                <small class="text-uppercase">Book Now</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row justify-content-center align-items-stretch">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 col-xxl-3 px-2 py-2">
                <div class="card card-bg border-0 bg-body rounded-3 h-100">
                    <div class="card-body px-3 py-4 d-flex justify-content-center">
                        <div class="d-flex justify-content-center flex-column align-items-stretch">
                            <div class="mx-auto d-block">
                                <img height="80" src="{{asset('images/learn_more.svg')}}"/>
                            </div>
                            <div class="mx-auto d-block">
                                <h4 class="fc-vyepti-teal text-center my-0">Learn More About Vyepti</h4>
                            </div>
                            <div class="h-100">
                                <div class="row h-100">
                                    <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                        <p class="card-text text-justify fs-7 fw-normal my-2">Vyepti is a powerful migraine
                                            preventive treatment. Click here for the full prescribing information of Vyepti,
                                            including our efficacy and safety data, administration guide and more.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="h-100">
                                <div class="row h-100">
                                    <div class="col-12 col-md-8 mx-auto align-self-end">
                                        <a href=""
                                            class="disabled btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                            <small class="text-uppercase">Coming Soon</small>
                                        </a>
                                        <!-- <a href="{{ URL::route('learnmore') }}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Learn More</small>
                                                </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 col-xxl-3 px-2 py-2">
                <div class="card card-bg border-0 bg-body rounded-3 h-100">
                    <div class="card-body px-3 py-4 d-flex justify-content-center">
                        <div class="d-flex justify-content-center flex-column align-items-stretch">
                            <div class="mx-auto d-block">
                                <img height="80" src="{{asset('images/calendar.svg')}}"/>
                            </div>
                            <div class="mx-auto d-block">
                                <h4 class="fc-vyepti-teal text-center my-0">Calendar Overview</h4>
                            </div>
                            <div class="h-100">
                                <div class="row h-100">
                                    <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                        <p class="card-text text-justify fs-7 fw-normal my-2">Click here for a monthly
                                            overview
                                            of your patients infusion bookings & upcoming visits for patients who are on
                                            Vyepti
                                            Power On Plan.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="h-100">
                                <div class="row h-100">
                                    <div class="col-12 col-md-8 mx-auto align-self-end">
                                        <a href="{{ URL::route('calendarview') }}"
                                            class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center ">
                                            <small class="text-uppercase">View Appointments</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
                <div class="row mt-3 px-0 mb-5 ">
                    <div class="col px-0 shadow mx-2 ">
                            <div class="card p-4 col-12">
                                <h3 class="dark-blue">Videos</h5>
                                // mobile
                                <div id="carouselExampleControls" class="carousel slide d-md-none" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active ">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of the video</p>
                                        </div>
                                        <div class="carousel-item">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of 2 the video</p>
                                        </div>
                                        <div class="carousel-item">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of 3 the video</p>
                                        </div>
                                        <div class="carousel-item ">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of the video</p>
                                        </div>
                                        <div class="carousel-item">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of 2 the video</p>
                                        </div>
                                        <div class="carousel-item">
                                            <iframe style="width:100%;" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                            <p class="col-12">Name of 3 the video</p>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                // web

                                <div id="carouselWebControls" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active ">
                                            <div class=" row ">
                                                <div class="col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the video</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the video</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the video</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item ">
                                            <div class=" col-12 row ">
                                                <div class=" col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the 2video</p>
                                                    </div>
                                                </div>
                                                <div class=" col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the 2video</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 mx-0 d-none d-md-block">
                                                    <div class="card border-white">
                                                        <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                                                        <p class="col-12">Name of the 2video</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselWebControls" data-bs-slide="prev" style="">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselWebControls" data-bs-slide="next" style="">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                </div> -->
    </div>
@endsection
