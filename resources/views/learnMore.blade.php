@extends('layouts.app')

@section('content')
<div class="container-fluid px-8">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><a href="{{ URL::route('home') }}" class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Vyepti</li>
            </ol>
        </nav>
    </div>
    <div class="row border-bottom">
        <h4 class="fc-vyepti-teal">About Vyepti </h4>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary " href="{{URL::route('efficacious')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/efficacious.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">Efficacious</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary" href="{{URL::route('fast')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/fast.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">Fast</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary" href="{{URL::route('sustained')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/sustained.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">Sustained</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary " href="{{URL::route('medication')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/medicationoveruse.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">Medication Overuse Headache</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary" href="{{URL::route('fusion')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/IVfusion.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">IV Fusion</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-md-4 px-2 py-1 my-2">
            <a class = "text-decoration-none text-primary" href="{{URL::route('safety')}}">
                <div class="card card-bg border-0 shadow-sm py-2">
                    <div class="card-body px-1">
                        <div class="d-flex flex-column align-content-center flex-wrap">
                            <div class="row justify-content-center ">
                                <div class="col-12 text-center">
                                    <object height="80" height="80" data="images/safety.svg"> </object>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-2">
                                <div class="col-12 text-center">
                                    <h4 class="fc-vyepti-teal text-center my-0">Safety</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection
