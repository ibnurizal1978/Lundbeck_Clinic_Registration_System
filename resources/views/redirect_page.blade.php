@extends('layouts.app')
@section('content')

<style>
    @media (max-width: 767px) {
        .carousel-inner .carousel-item > div {
            display: none;
        }
        .carousel-inner .carousel-item > div:first-child {
            display: block;
        }
    }

    .carousel-inner .carousel-item.active,
    .carousel-inner .carousel-item-next,
    .carousel-inner .carousel-item-prev {
        display: flex;
    }

    /* medium and up screens */
    @media (min-width: 768px) {        
        .carousel-inner .carousel-item-end.active,
        .carousel-inner .carousel-item-next {
            transform: translateX(50%);
        }
        
        .carousel-inner .carousel-item-start.active, 
        .carousel-inner .carousel-item-prev {
            transform: translateX(-50%);
        }
    }

    .carousel-inner .carousel-item-end,
    .carousel-inner .carousel-item-start { 
        transform: translateX(0);
    }


</style>
<div class="container-fluid px-8">
    <div class="row mx-auto my-auto justify-content-center">
        <!-- success message -->
        @if(session()->has('message'))
            <div class="alert alert-success btn-vyepti-steel-50">
                {{ session()->get('message') }} 
                <a href="{{ url('/home') }}" style="color: black;">Back to home screen</a>
                <div class="col-6"> </div>
            </div>
        @endif

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @if(session()->get('origin') == 'psp')
                <div class="carousel-item active">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/IVfusion.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Infusion Appointment</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Book a 30 minutes hassle free infusion service with our professional nurse agency team at the preferred date and time of your patient.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('CreateAppointment')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Book Now</small> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/calendar.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Calendar Overview</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Click here for a monthly overview of your patients infusion bookings & upcoming visits for patients who are on Vyepti Power On Plan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('calendarview')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center ">
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
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/learn_more.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Learn More About Vyepti</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Vyepti is a powerful migraine preventive treatment. Click here for the full prescribing information of Vyepti, including our efficacy and safety data, administration guide and more.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="" class="disabled btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Coming Soon</small> 
                                                </a>
                                                <!-- <a href="{{URL::route('learnmore')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Learn More</small> 
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/efficacious.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Vyepti Power-on Treatment Plan</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">A treatment plan for your patients to be started on the right treatment, stay on track, and to take control of their migraine as long as possible!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('RegisterPSP')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Enroll Now</small> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="carousel-item active">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/calendar.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Calendar Overview</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Click here for a monthly overview of your patients infusion bookings & upcoming visits for patients who are on Vyepti Power On Plan.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('calendarview')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center ">
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
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/efficacious.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Vyepti Power-on Treatment Plan</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">A treatment plan for your patients to be started on the right treatment, stay on track, and to take control of their migraine as long as possible!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('RegisterPSP')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Enroll Now</small> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/learn_more.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Learn More About Vyepti</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Vyepti is a powerful migraine preventive treatment. Click here for the full prescribing information of Vyepti, including our efficacy and safety data, administration guide and more.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="" class="disabled btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Coming Soon</small> 
                                                </a>
                                                <!-- <a href="{{URL::route('learnmore')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Learn More</small> 
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-6 px-2 py-2">
                        <div class="card card-bg border-0 bg-body rounded-3 h-100">
                            <div class="card-body px-3 py-4 d-flex justify-content-center">
                                <div class="d-flex justify-content-center flex-column align-items-stretch">
                                    <div class="mx-auto d-block">
                                        <object height="80" data="images/IVfusion.svg"> </object>
                                    </div>
                                    <div class="mx-auto d-block">
                                        <h4 class="fc-vyepti-teal text-center my-0">Infusion Appointment</h4>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-lg-12 col-xl-10 mx-auto d-block">
                                                <p class="card-text text-justify fs-7 fw-normal my-2">Book a 30 minutes hassle free infusion service with our professional nurse agency team at the preferred date and time of your patient.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-100">
                                        <div class="row h-100">
                                            <div class="col-12 col-md-8 mx-auto align-self-end">
                                                <a href="{{URL::route('CreateAppointment')}}" class="btn btn-light btn-vyepti-teal fc-vyepti-steel-20 rounded-pill d-flex justify-content-center align-items-center">
                                                    <small class="text-uppercase">Book Now</small> 
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <button class="carousel-control-prev btn btn-light fc-vyepti-teal btn-circle my-auto" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <i class="fa fa-chevron-left"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next btn btn-light fc-vyepti-teal btn-circle my-auto" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <i class="fa fa-chevron-right"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<script>
    let items = document.querySelectorAll('.carousel .carousel-item')

    items.forEach((el) => {
        const minPerSlide = 2;
        let next = el.nextElementSibling
        for (var i=1; i<minPerSlide; i++) {
            if (!next) {
                // wrap carousel by using first child
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })


</script>
@endsection
